<?php
/*
 * CKFinder Configuration File
 */

// Disable error reporting for production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);

// Create config array
$config = array();

// Enable authentication - always return true for admin area
$config['authentication'] = function() {
    return true;
};

// Set license key (free for testing)
$config['licenseName'] = '';
$config['licenseKey']  = '';

// Configure private directory for CKFinder
$config['privateDir'] = array(
    'backend' => 'default',
    'tags'   => '.ckfinder/tags',
    'logs'   => '.ckfinder/logs',
    'cache'  => '.ckfinder/cache',
    'thumbs' => '.ckfinder/cache/thumbs',
);

// Configure image settings
$config['images'] = array(
    'maxWidth'  => 0, // 0 = không giới hạn
    'maxHeight' => 0, // 0 = không giới hạn
    'quality'   => 85,
    'sizes' => array(
        'small'  => array('width' => 480, 'height' => 320, 'quality' => 85),
        'medium' => array('width' => 800, 'height' => 600, 'quality' => 85),
        'large'  => array('width' => 1200, 'height' => 800, 'quality' => 85)
    )
);

// Configure the main file storage
$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => '/QuynhNhu/DoAnWebBanHoa/admin/uploads/',
    'root'         => '', // Auto-detect
    'chmodFiles'   => 0644,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8'
);

// Configure default resource type
$config['defaultResourceTypes'] = '';

// Configure available resource types - chỉ dùng một resource type
$config['resourceTypes'][] = array(
    'name'              => 'Files', // Tên hiển thị trong CKFinder
    'directory'         => '/', // Sử dụng thư mục gốc
    'maxSize'           => 0, // 0 = không giới hạn dung lượng
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
    'deniedExtensions'  => '',
    'backend'          => 'default'
);

// Configure access control
$config['roleSessionVar'] = 'CKFinder_UserRole';

// Grant full access to the admin
$config['accessControl'][] = array(
    'role'                => '*',
    'resourceType'        => '*',
    'folder'             => '/',

    'FOLDER_VIEW'        => true,
    'FOLDER_CREATE'      => true,
    'FOLDER_RENAME'      => true,
    'FOLDER_DELETE'      => true,

    'FILE_VIEW'          => true,
    'FILE_CREATE'        => true,
    'FILE_RENAME'        => true,
    'FILE_DELETE'        => true,

    'IMAGE_RESIZE'       => true,
    'IMAGE_RESIZE_CUSTOM'=> true
);

// Security settings
$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = true;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = false;
$config['xSendfile'] = false;

// Debug settings
$config['debug'] = false;

// Plugin settings
$config['pluginsDirectory'] = __DIR__ . '/plugins';
$config['plugins'] = array();

// Cache settings
$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails'   => 24 * 3600 * 365,
    'proxyCommand' => 0
);

// Temp directory settings
$config['tempDirectory'] = sys_get_temp_dir();

// Session settings
$config['sessionWriteClose'] = true;

// CSRF protection
$config['csrfProtection'] = true;

// Headers
$config['headers'] = array();

// Return the configuration
return $config;