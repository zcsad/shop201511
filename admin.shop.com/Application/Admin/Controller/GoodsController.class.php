<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsController extends BaseController
{
    protected $meta_title = '商品';

    //页面展示之前被调用,向页面上分配数据
    protected function _before_edit_view()
    {
//        准备分类数据,分配到页面
        $goodsModel = D('GoodsCategory');
        $goodsCategoryes = $goodsModel->getList();
        $this->assign('nodes', json_encode($goodsCategoryes));
//        准备品牌数据, 分配到页面
        $brandModel = D('Brand');
        $brands = $brandModel->getShowList();
        $this->assign('brands', $brands);
//        准备供货商数据, 分配到页面
        $supplierModel = D('Supplier');
        $suppliers = $supplierModel->getShowList();
        $this->assign('suppliers', $suppliers);
//       准备会员级别数据, 分配到页面
        $memberLevelModel = D('MemberLevel');
        $memberLevels = $memberLevelModel->getShowList('id,name');
        $this->assign('memberLevels', $memberLevels);


//        编辑时查询出当前商品对应的描述内容
        $id = I('get.id', '');
        if (!empty($id)) {
            //id不为空说明是编辑
            //查询出商品对应描述内容
            $goodsIntroModel = M('GoodsIntro');
            $intro = $goodsIntroModel->getFieldByGoods_id($id, 'intro');
            $this->assign('intro', $intro);
            //查询出商品对应图片
            $goodsGalleryModel = D('GoodsGallery');
            $goodsGallerys = $goodsGalleryModel->getGalleryByGoods_id($id);
            $this->assign('goodsGallerys', $goodsGallerys);
            //查询出商品对应的文章数据
            $goodsArticleModel = D('GoodsArticle');
            $goodsAritcles = $goodsArticleModel->getArticleByGoodsId($id);
            $this->assign('goodsAritcles', $goodsAritcles);
            //根据商品的id将当前商品的会员价格查询出来
            $goodsMemberPriceModel = D('GoodsMemberPrice');
            $goodsMemberPrice = $goodsMemberPriceModel->getMemberPrice($id);
            $this->assign('goodsMemberPrice',$goodsMemberPrice);

        }
    }


    public function add()
    {
        if (IS_POST) {
            //>>1.使用模型中的create方法收集并且验证, 自动完成
            if ($this->model->create() !== false) {
                //>>3.添加到数据库中
                $requestData = I('post.');
                //通过第三个参数告知不进行额外处理,原样输出/入
                $requestData['intro'] = I('post.intro', '', false);
                if ($this->model->add($requestData) !== false) {
                    $this->success('添加成功!', cookie('__forward__'));
                    return;  //防止后面的代码执行.
                }
            }
            $this->error('操作失败!' . showErrors($this->model));
        } else {
            $this->_before_edit_view();
            $this->assign('meta_title', '添加' . $this->meta_title);
            $this->display('edit');
        }
    }


    public function edit($id)
    {
        if (IS_POST) {
            //>>1.收集更新的数据
            if ($this->model->create() !== false) {
                $requestData = I('post.');
                $requestData['intro'] = I('post.intro', '', false);  //通过第三个参数告知不进行额外处理
                if ($this->model->save($requestData) !== false) {
                    $this->success('更新成功!', cookie('__forward__'));
                    return;
                }
            }
            $this->error('操作失败!' . showErrors($this->model));
        } else {
            //>>2.根据id查询一行记录
            $row = $this->model->find($id);
            //>>3.将数据分配到页面上
            $this->assign($row);
            //>>4.选择视图页面显示
            $this->assign('meta_title', '编辑' . $this->meta_title);
            //>>5.调用钩子函数
            $this->_before_edit_view();
            $this->display('edit');
        }
    }

//根据商品的id删除图片
    public function deleteGallery($gallery_id)
    {
        $goodsGalleryModel = D('GoodsGallery');
        $result = array('success' => false);
        if ($goodsGalleryModel->delete($gallery_id) !== false) {
            $result['success'] = true;
        }
        $this->ajaxReturn($result);
    }

}