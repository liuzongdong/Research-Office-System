<?php
	$ldap_host = "ldap://ServerIP";
	$ldap_port = "ServerPort";

	$ldap_user = "mail=uid@mail.com;virtualDomain=mail.com;o=Account;dc=org"; //DN
	$ldap_pwd = "123456";
	$ldap_conn = ldap_connect($ldap_host, $ldap_port);
	//$set = ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);    //设置参数，这个目前还不了解

	if(!$ldap_conn)
	{
    	die("Can't connect to LDAP server");
	}
	ldap_bind($ldap_conn, $ldap_user, $ldap_pwd) or die("Can't bind to LDAP server.");//与服务器绑定

	if(ldap_errno($ldap_conn)!=0)
	{
	  echo "Can't log in! ".ldap_error($ldap_conn)."<br>";
	}
	else
	{
	  echo "Welcome $ldap_user";
	}
	ldap_unbind($ldap_conn) or die("Can't unbind from LDAP server."); //与服务器断开连接
?>
