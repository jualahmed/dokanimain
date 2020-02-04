<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitef4e5afef088b92d22e1407d70c2861e
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/..' . '/illuminate/support/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Contracts\\Translation\\' => 30,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Container\\' => 14,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Database\\' => 20,
            'Illuminate\\Contracts\\' => 21,
            'Illuminate\\Container\\' => 21,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Inflector\\' => 26,
        ),
        'C' => 
        array (
            'Carbon\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Contracts\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation-contracts',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/support',
        ),
        'Illuminate\\Database\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/database',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
        'Illuminate\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/container',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
        'Carbon\\' => 
        array (
            0 => __DIR__ . '/..' . '/nesbot/carbon/src/Carbon',
        ),
    );

    public static $classMap = array (
        'Access_control_model' => __DIR__ . '/../..' . '/application/models/Access_control_model.php',
        'Account_model' => __DIR__ . '/../..' . '/application/models/Account_model.php',
        'Admin_model' => __DIR__ . '/../..' . '/application/models/Admin_model.php',
        'Bankcard_model' => __DIR__ . '/../..' . '/application/models/Bankcard_model.php',
        'Cashbook' => __DIR__ . '/../..' . '/application/models/Cashbook.php',
        'Category_model' => __DIR__ . '/../..' . '/application/models/Category_model.php',
        'Checkout_model' => __DIR__ . '/../..' . '/application/models/Checkout_model.php',
        'Comission_model' => __DIR__ . '/../..' . '/application/models/Comission_model.php',
        'Company_model' => __DIR__ . '/../..' . '/application/models/Company_model.php',
        'Customer_model' => __DIR__ . '/../..' . '/application/models/Customer_model.php',
        'Customerm' => __DIR__ . '/../..' . '/application/models/Customerm.php',
        'Damageproduct_model' => __DIR__ . '/../..' . '/application/models/Damageproduct_model.php',
        'Distributor_model' => __DIR__ . '/../..' . '/application/models/Distributor_model.php',
        'Employee_model' => __DIR__ . '/../..' . '/application/models/Employee_model.php',
        'Excel_model' => __DIR__ . '/../..' . '/application/models/Excel_model.php',
        'Exchange_model' => __DIR__ . '/../..' . '/application/models/Exchange_model.php',
        'Expense_invoice_model' => __DIR__ . '/../..' . '/application/models/Expense_invoice_model.php',
        'Expense_model' => __DIR__ . '/../..' . '/application/models/Expense_model.php',
        'Joy_model' => __DIR__ . '/../..' . '/application/models/Joy_model.php',
        'Loanm' => __DIR__ . '/../..' . '/application/models/Loanm.php',
        'Login_attempts' => __DIR__ . '/../..' . '/application/models/tank_auth/Login_attempts.php',
        'Login_model' => __DIR__ . '/../..' . '/application/models/Login_model.php',
        'Membership_model' => __DIR__ . '/../..' . '/application/models/Membership_model.php',
        'Modify_model' => __DIR__ . '/../..' . '/application/models/Modify_model.php',
        'Product_model' => __DIR__ . '/../..' . '/application/models/Product_model.php',
        'Purchase_model' => __DIR__ . '/../..' . '/application/models/Purchase_model.php',
        'Purchaseinfom' => __DIR__ . '/../..' . '/application/models/Purchaseinfom.php',
        'Purchaselisting_model' => __DIR__ . '/../..' . '/application/models/Purchaselisting_model.php',
        'Purchasereceiptinfom' => __DIR__ . '/../..' . '/application/models/Purchasereceiptinfom.php',
        'Purchasereceiptm' => __DIR__ . '/../..' . '/application/models/Purchasereceiptm.php',
        'Registration_model' => __DIR__ . '/../..' . '/application/models/Registration_model.php',
        'Report_model' => __DIR__ . '/../..' . '/application/models/Report_model.php',
        'Sale_model' => __DIR__ . '/../..' . '/application/models/Sale_model.php',
        'Salereturn_model' => __DIR__ . '/../..' . '/application/models/Salereturn_model.php',
        'Setup_model' => __DIR__ . '/../..' . '/application/models/Setup_model.php',
        'Shop_model' => __DIR__ . '/../..' . '/application/models/Shop_model.php',
        'Site_model' => __DIR__ . '/../..' . '/application/models/Site_model.php',
        'Transactionm' => __DIR__ . '/../..' . '/application/models/Transactionm.php',
        'Unit_model' => __DIR__ . '/../..' . '/application/models/Unit_model.php',
        'User_Autologin' => __DIR__ . '/../..' . '/application/models/tank_auth/User_autologin.php',
        'Users' => __DIR__ . '/../..' . '/application/models/tank_auth/Users.php',
        'Web_model' => __DIR__ . '/../..' . '/application/models/Web_model.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitef4e5afef088b92d22e1407d70c2861e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitef4e5afef088b92d22e1407d70c2861e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitef4e5afef088b92d22e1407d70c2861e::$classMap;

        }, null, ClassLoader::class);
    }
}
