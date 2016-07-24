<?php

/**
 * @author zhanglirong
 * @date 2016.04.25
 * @time 12:38 pm
 */



class QLibConfigs_Assets {

    /**
     * css 配置
     * @var Array
     */
    public static $_css = array(

        /* datatable插件 */
        'datatables' => '/Public/assets/global/plugins/datatables/plugins/datatables/datatables.css',
        'datatables.bootstrap' => '/Public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.min.css',

        /* Extended Modals插件 */
        'bootstrap-modal-bs3patch' => '/Public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css',
        'bootstrap-modal' => '/Public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css',

        /* jstree */
        'jstree' => '/Public/assets/global/plugins/jstree/dist/themes/default/style.min.css',

        /* fancybox */
        'fancybox' => '/Public/assets/global/plugins/fancybox/source/jquery.fancybox.css',
    );

    public static $staticUrl = 'http://static.hunchelaila.com';

    /**
     * js配置
     * @var array
     */
    public static $_js = array(
        /* 页面js */
        'showrollback' => '/Public/assets/pages/scripts/operations/release/showrollback.js',
        'showserver' => '/Public/assets/pages/scripts/operations/release/showserver.js',

        'resource-index' => '/Public/assets/pages/scripts/cms/resource/index.js',
        'resource-add' => '/Public/assets/pages/scripts/cms/resource/add.js',
        'resource-edit' => '/Public/assets/pages/scripts/cms/resource/edit.js',

        'update-edit' => '/Public/assets/pages/scripts/erp/update/edit.js',
        'sms-index' => '/Public/assets/pages/scripts/erp/sms/index.js',
        'auth-add' => '/Public/assets/pages/scripts/core/auth/add.js',
        'auth-index' => '/Public/assets/pages/scripts/core/auth/index.js',
        'evaluation-index' => '/Public/assets/pages/scripts/erp/evaluation/index.js',
        'knowledge-index' => '/Public/assets/pages/scripts/erp/knowledge/index.js',

        'carteam-main' => '/Public/assets/pages/scripts/erp/carteam/main.js',
        'rob-main' => '/Public/assets/pages/scripts/erp/rob/main.js',
        'orderspackage-main' => '/Public/assets/pages/scripts/erp/orderspackage/main.js',
        'teamorders-main' => '/Public/assets/pages/scripts/erp/teamorders/main.js?20160711',
        
        'brandlist' => '/Public/assets/pages/scripts/cms/carprop/brand.js',

        /* datatable插件 */
        'datatable' => '/Public/assets/global/scripts/datatable.js',
        'datatables' => '/Public/assets/global/plugins/datatables/datatables.min.js',
        'datatables.bootstrap' => '/Public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',

        /* Extended Modals插件 */
        'bootstrap-modalmanager' => '/Public/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js',
        'bootstrap-modal' => '/Public/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js',

        /* 表单验证插件 */
        'form-validation' => '/Public/assets/global/plugins/jquery-validation/js/jquery.validate.min.js',

        /* jstree */
        'jstree' => '/Public/assets/global/plugins/jstree/dist/jstree.min.js',

        /* fancybox */
        'fancybox' => '/Public/assets/global/plugins/fancybox/source/jquery.fancybox.js',
    );

    public static $oldAdminTest = 'http://admin.hunchelaila.com';

    public static $oldAdmin = 'http://portal.admin.hunchelaila.com';

    public static $siteUrl = 'http://portal.hunchelaila.com';
}