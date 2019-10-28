<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit910fee3465593eef031f7207076f1151
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Palasthotel\\Grid\\WordPress\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Palasthotel\\Grid\\WordPress\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Palasthotel\\Grid\\WordPress\\Ajax' => __DIR__ . '/../..' . '/classes/Ajax.php',
        'Palasthotel\\Grid\\WordPress\\Boxes' => __DIR__ . '/../..' . '/classes/Boxes.php',
        'Palasthotel\\Grid\\WordPress\\ContainerFactory' => __DIR__ . '/../..' . '/classes/ContainerFactory.php',
        'Palasthotel\\Grid\\WordPress\\Copy' => __DIR__ . '/../..' . '/classes/Copy.php',
        'Palasthotel\\Grid\\WordPress\\MetaBoxes' => __DIR__ . '/../..' . '/classes/MetaBoxes.php',
        'Palasthotel\\Grid\\WordPress\\PositionInPost' => __DIR__ . '/../..' . '/classes/PositionInPost.php',
        'Palasthotel\\Grid\\WordPress\\Post' => __DIR__ . '/../..' . '/classes/Post.php',
        'Palasthotel\\Grid\\WordPress\\Privileges' => __DIR__ . '/../..' . '/classes/Privileges.php',
        'Palasthotel\\Grid\\WordPress\\ReuseBox' => __DIR__ . '/../..' . '/classes/ReuseBox.php',
        'Palasthotel\\Grid\\WordPress\\ReuseContainer' => __DIR__ . '/../..' . '/classes/ReuseContainer.php',
        'Palasthotel\\Grid\\WordPress\\Settings' => __DIR__ . '/../..' . '/classes/Settings.php',
        'Palasthotel\\Grid\\WordPress\\StorageHelper' => __DIR__ . '/../..' . '/classes/StorageHelper.php',
        'Palasthotel\\Grid\\WordPress\\Styles' => __DIR__ . '/../..' . '/classes/Styles.php',
        'Palasthotel\\Grid\\WordPress\\TheGrid' => __DIR__ . '/../..' . '/classes/TheGrid.php',
        'Palasthotel\\Grid\\WordPress\\Update' => __DIR__ . '/../..' . '/classes/Update.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit910fee3465593eef031f7207076f1151::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit910fee3465593eef031f7207076f1151::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit910fee3465593eef031f7207076f1151::$classMap;

        }, null, ClassLoader::class);
    }
}
