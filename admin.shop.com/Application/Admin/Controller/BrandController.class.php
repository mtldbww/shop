<?php

namespace Admin\Controller;

/**
 * 该控制器用于品牌管理
 *
 * @author feng
 */
class BrandController extends \Think\Controller {

    /**
     * 构造方法，自动创建模型
     * @var \Admin\Model\BrandModel
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Brand');
    }

    /**
     * 显示页面
     */
    public function index() {
        //获取关键字
        $name           = I('get.name');
        $cond['status'] = ['egt', 0];
        if ($name) {
            $cond['name'] = ['like', '%' . $name . '%'];
        }
        //查询数据
        $rows = $this->_model->getPage($cond);
        //传递数据
        $this->assign($rows);
        //显示页面
        $this->display();
    }

    /**
     * 增加品牌
     */
    public function add() {
        //接受数据
        if (IS_POST) {
            //收集数据
            if ($this->_model->create() === FALSE) {
                $this->error(get_error($this->_model));
            }
            //保存数据
            if ($this->_model->add() === FALSE) {
                $this->error(get_error($this->_model));
            } else {
                //提示跳转
                $this->success('添加成功', U('index'));
            }
        } else {
            //显示页面
            $this->display();
        }
    }

    /**
     * 修改品牌
     */
    public function edit($id) {
        //接受数据
        if (IS_POST) {
            if ($this->_model->create() === FALSE) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->save() === FALSE) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功', U('index'));
        } else {
            //收集数据
            $row = $this->_model->find($id);
            //传递数据
            $this->assign('row', $row);
            //显示页面
            $this->display();
        }
    }

    /**
     * 删除品牌
     */
    public function del($id) {
        $data = [
            'id'     => $id,
            'status' => -1,
            'name'   => ['exp', 'concat(name,"_del")']
        ];
        //调用模型删除
        if ($this->_model->setField($data) === FALSE) {
            $this->error(get_error($this->_model));
        } else {
            //跳转
            $this->success('删除成功', U('index'));
        }
    }

}
