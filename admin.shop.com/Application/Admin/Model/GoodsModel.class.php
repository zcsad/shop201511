<?php
namespace Admin\Model;


use Think\Model;

class GoodsModel extends BaseModel
{
    // 自动验证定义
    protected $_validate_1 = array(
        array('name', 'require', '名称不能够为空!'),
        array('sn', 'require', '货号不能够为空!'),
        array('goods_category_id', 'require', '父分类不能够为空!'),
        array('brand_id', 'require', '品牌不能够为空!'),
        array('supplier_id', 'require', '供货商不能够为空!'),
        array('shop_price', 'require', '本店价格不能够为空!'),
        array('market_price', 'require', '市场价格不能够为空!'),
        array('stock', 'require', '库存不能够为空!'),
        array('is_on_sale', 'require', '是否上架不能够为空!'),
        array('goods_status', 'require', '商品状态不能够为空!'),
        array('keyword', 'require', '关键字不能够为空!'),
        array('logo', 'require', 'LOGO不能够为空!'),
        array('status', 'require', '状态不能够为空!'),
        array('sort', 'require', '排序不能够为空!'),
    );
//添加
    public function add($requestData)
    {
        //开启事物
        $this->startTrans();
        //计算商品状态
        $this->handleGoodsStatus();
  //货号  日期+8位id 不够补0
        //一定要调用parent上的add,  因为先保存后才有id的值
        $id = parent::add();
        if($id===false){
            //id没值,事物回滚
            $this->rollback();
            return false;
        }
//        准备货号 并且将货号更新到数据库中
        $sn=date('Ymd').str_pad($id,8,"0",STR_PAD_LEFT);
        $result=parent::save(array('sn'=>$sn,'id'=>$id));
        if($result===false){
            //不成功,事物回滚
            $this->rollback();
            return false;
        }
        //处理商品简介
        $result = $this->handleGoodsIntro($id,$requestData['intro']);
        if($result===false){
            return false;
        }
        //处理商品相册
        $result = $this->handleGoodsGallery($id,$requestData['gallery_path']);
        if($result===false){
            return false;
        }
        //处理关联文章
        $result = $this->handleGoodsArticle($id,$requestData['article_id']);
        if($result===false){
            return false;
        }
        //处理商品会员价格
        $result = $this->handleGoodsMemberPrice($id,$requestData['memberPrice']);
        if($result===false){
            return false;
        }

        //提交事物
        $this->commit();
        return $id;
    }

//保存更新
    public function save($requestData){
        $this->startTrans();
        //计算商品状态
        $this->handleGoodsStatus();
        //需要将请求中的商品描述goods_intro中
        $result = $this->handleGoodsIntro($this->data['id'],$requestData['intro']);
        if($result===false){
            return false;
        }
        //处理商品相册
        $result = $this->handleGoodsGallery($this->data['id'],$requestData['gallery_path']);
        if($result===false){
            return false;
        }
        //处理关联文章
        $result = $this->handleGoodsArticle($this->data['id'],$requestData['article_id']);
        if($result===false){
            return false;
        }
        //处理会员价格
        $result = $this->handleGoodsMemberPrice($this->data['id'],$requestData['memberPrice']);
        if($result===false){
            return false;
        }



        //进行更新
        $result = parent::save();
        if($result===false){
            $this->rollback();
            return false;
        }
        //提交事物
        $this->commit();
        return $result;
    }
//商品状态
    private function handleGoodsStatus()
    {
       //商品状态
        $goods_status = 0;
        foreach ($this->data['goods_status'] as $v) {
            $goods_status = $goods_status | $v;
        }
        $this->data['goods_status'] = $goods_status;
    }

//商品描述
    private  function handleGoodsIntro($goods_id,$intro){
        $goodsIntroModel = M('GoodsIntro');
        //先删除原来的,再保存新的, 如果没有原来的无法不用删除
        $goodsIntroModel->where(array('goods_id'=>$goods_id))->delete();
        $result = $goodsIntroModel->add(array('goods_id'=>$goods_id,'intro'=>$intro));
        if($result===false){
            $this->rollback();
            $this->error = '保存商品描述失败!';
            return false;
        }
    }
    //图片操作
    private function handleGoodsGallery($id,$gallery_paths){
        $rows=array();
        foreach($gallery_paths as $gallery_path){
            $rows[]=array('goods_id'=>$id,'path'=>$gallery_path);
        }
        if(!empty($rows)){
            $goodsGallerModel=M('GoodsGallery');
            $result=$goodsGallerModel->addAll($rows);
            if($result===false){
                $this->rollback();
                $this->error='保存图片错误';
                return false;
            }
        }
    }

//文章方法
    private function handleGoodsArticle($id,$article_ids){
        $rows = array();
        foreach($article_ids as $article_id){
            $rows[] =  array('goods_id'=>$id,'article_id'=>$article_id);
        }
        if(!empty($rows)){
            $goodsArticleModel = M('GoodsArticle');
            //把更新文章的所有看做一个整体,先全部删除了,在添加,   以一个整体来看待
            $goodsArticleModel->where(array('goods_id'=>$id))->delete();
            $result  = $goodsArticleModel->addAll($rows);
            if($result===false){
                $this->rollback();
                $this->error = '保存相关文章失败!';
                return false;
            }
        }
    }

//会员价格
    private function handleGoodsMemberPrice($goods_id,$memberPrices){
        $rows = array();
        foreach($memberPrices as $member_level_id=>$price){
            $rows[] =  array('goods_id'=>$goods_id,'member_level_id'=>$member_level_id,'price'=>$price);
        }
        if(!empty($rows)){
            $goodsMemberPriceModel = M('GoodsMemberPrice');
            //先删除,在更新
            $goodsMemberPriceModel->where(array('goods_id'=>$goods_id))->delete();
            $result = $goodsMemberPriceModel->addAll($rows);
            if($result===false){
                $this->error = '保存会员价格失败!';
                $this->rollback();
                return false;
            }
        }
    }



}
