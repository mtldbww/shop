<?php

namespace Admin\Model;

/**
 * Description of SupplierModel
 *
 * @author feng
 */
class SupplierModel extends \Think\Model {

//批量验证
    protected $patchValidate = true;
//自动验证
    protected $_validate     = [
        ['name', 'require', '名称必填'],
        ['name', '', '名称已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '状态不合法', self::EXISTS_VALIDATE, 'in'],
        ['sort', 'number', '排序必须为数字']
    ];

    /**
     * 获取分页
     * @param array $cond
     */
    public function getPage(array $cond = []) {
        //获取分页代码
        //获取总行数
        //获取分页配置
        $page_setting = C('PAGE_SETTING');
        $count        = $this->where($cond)->count();
        $page         = new \Think\Page($count, $page_setting['PAGE_SIZE']);
        //更改page设置
        $page->setConfig('theme', $page_setting['THEME']);
        $page_html    = $page->show();
        //获取分页数据
        $rows         = $this->where($cond)->page(I('get.p', 1), $page_setting['PAGE_SIZE'])->select();
        return [
            'rows'      => $rows,
            'page_html' => $page_html
        ];
    }

}
