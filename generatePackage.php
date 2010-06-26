<?php

require_once('PEAR/PackageFileManager2.php');

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packagexml = new PEAR_PackageFileManager2;

$packagexml->setOptions(array(
    'baseinstalldir'    => '/',
    'simpleoutput'      => true,
    'packagedirectory'  => './',
    'filelistgenerator' => 'file',
    'ignore'            => array('runTests.php', 'generatePackage.php'),
    'dir_roles' => array(
        'tests'     => 'test',
        'examples'  => 'doc'
    ),
));

$packagexml->setPackage('OpenID');
$packagexml->setSummary('PHP implementation of OpenID 1.1 and 2.0');
$packagexml->setDescription(
    'OpenID is a free and easy way to use a single digital identity across the '
    . 'Internet. See http://openid.net for details.'
);

$packagexml->setChannel('pear.php.net');
$packagexml->setAPIVersion('0.2.0');
$packagexml->setReleaseVersion('0.2.0');

$packagexml->setReleaseStability('alpha');

$packagexml->setAPIStability('alpha');

$packagexml->setNotes('* Fixed #17481.  OpenID_Message wasn\'t checking input of http formatted messages before assigning key/values
* fix E_STRICT error: Strict standards: Only variables should be passed by reference in OpenID/RelyingParty.php on line 226 (cweiske)
* get rid of date dependency. there was also a but that prevented the expiration time from working (using of $expire instead of $expireTime) (cweiske)
* get rid of PEAR dependency, we only need the PEAR installer dep (cweiske)
* get rid of PEAR Validate dependency and use filter_var() instead (cweiske)
* Fixed all @link annotations, added README (shupp)');
$packagexml->setPackageType('php');
$packagexml->addRelease();

$packagexml->detectDependencies();

$packagexml->addMaintainer('lead',
                           'shupp',
                           'Bill Shupp',
                           'shupp@php.net');

$packagexml->addMaintainer('lead',
                           'richid',
                           'Rich Schumacher',
                           'rich.schu@gmail.com');
$packagexml->setLicense('New BSD License',
                        'http://www.opensource.org/licenses/bsd-license.php');

$packagexml->setPhpDep('5.1.2');
$packagexml->setPearinstallerDep('1.4.0b1');
$packagexml->addPackageDepWithChannel('required', 'PEAR', 'pear.php.net', '1.4.0');
$packagexml->addPackageDepWithChannel('required', 'HTTP_Request2', 'pear.php.net', '0.5.1');
$packagexml->addPackageDepWithChannel('required', 'Cache_Lite', 'pear.php.net');
$packagexml->addPackageDepWithChannel('required', 'Crypt_DiffieHellman', 'pear.php.net');
$packagexml->addPackageDepWithChannel('required', 'Services_Yadis', 'pear.php.net', '0.4.0');
$packagexml->addPackageDepWithChannel('optional', 'Log', 'pear.php.net');
$packagexml->addPackageDepWithChannel('required', 'Net_URL2', 'pear.php.net', '0.2.0');
$packagexml->addPackageDepWithChannel('optional', 'MDB2', 'pear.php.net');
$packagexml->addPackageDepWithChannel('optional', 'HTTP_OAuth', 'pear.php.net', '0.1.7');
$packagexml->addExtensionDep('required', 'date'); 
$packagexml->addExtensionDep('required', 'dom'); 
$packagexml->addExtensionDep('required', 'hash'); 
$packagexml->addExtensionDep('required', 'libxml'); 
$packagexml->addExtensionDep('required', 'mbstring'); 
$packagexml->addExtensionDep('required', 'pcre'); 
$packagexml->addExtensionDep('required', 'SPL'); 


$packagexml->generateContents();
$packagexml->writePackageFile();

?>
