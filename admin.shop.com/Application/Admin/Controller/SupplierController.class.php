<?php

namespace Admin\Controller;

/**
 * 该控制器用于供货商的管理
 *
 * @author feng
 */
class SupplierController extends \Think\Controller {

    /**
     * 构造方法，自动创建模型
     * @var \Admin\Model\SupplierModel
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Supplier');
    }

    /**
     * 列表页面
     */
    public function index() {
        //获取搜索关键字
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
     * 添加供货商
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
     * 逻辑删除供货商
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

    /**
     * 修改供货商
     */
    public function edit($id) {
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

}
