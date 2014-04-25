<?php
require_once ('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員註冊</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function chk(theForm){
	if (theForm.member_user.value.replace(/(^\s*)|(\s*$)/g, "") == ""){
		alert("帳號不能為空！");
		theForm.member_user.focus();   
		return (false);   
	}		
	
	if (theForm.member_password.value.replace(/(^\s*)|(\s*$)/g, "") == ""){
		alert("密碼不能為空！");
		theForm.member_password.focus();   
		return (false);   
	}	
	
	if (theForm.member_password.value != theForm.pass.value){
		alert("兩次輸入的密碼不一樣！");
		theForm.pass.focus();   
		return (false);   
	}	
		 
	if (theForm.member_name.value.replace(/(^\s*)|(\s*$)/g, "") == "" || theForm.member_name.value.replace(/[\u4e00-\u9fa5]/g, "")){
		alert("真實姓名不能為空且必須為中文！");   
		theForm.member_name.focus();   
		return (false);   
	}
}
</script>
<?php
if($_POST["submit"]){
if(empty($_POST['member_user']))
	echo "<script>alert('帳號不能為空');location='?tj=register';</script>";
else if(empty($_POST['member_password']))
	echo "<script>alert('密碼不能為空');location='?tj=register';</script>";
else if($_POST['member_password']!=$_POST['pass'])
	echo "<script>alert('兩次密碼不一樣');location='?tj=register';</script>";
else if(!empty($_POST['member_phone'])&&!is_numeric($_POST['member_phone']))
	echo "<script>alert('手機號碼必須全為數字');location='?tj=register';</script>";
else if(!empty($_POST['member_email'])&&!ereg("([0-9a-zA-Z]+)([@])([0-9a-zA-Z]+)(.)([0-9a-zA-Z]+)",$_POST['member_email']))
	echo "<script>alert('電子信箱輸入不合規定');location='?tj=register';</script>";
else{
$_SESSION['member']=$_POST['member_user'];
$sql="insert into member values('','".$_POST['member_user']."','".md5($_POST['member_password'])."','".$_POST['member_name']."','".$_POST['member_sex']."','".$_POST['member_phone']."','".$_POST['member_email']."')";
$result=mysql_query($sql)or die(mysql_error());
if($result)
echo "<script>alert('恭喜你註冊成功,馬上進入主頁面');location='member.php';</script>";
else
{
	echo "<script>alert('註冊失敗');location='index.php';</script>";
	mysql_close();
}
	}
}
?>
</head>
<body>
<?php if($_GET['tj'] == 'register'){ ?>
<form id="theForm" name="theForm" method="post" action="" onSubmit="return chk(this)" runat="server" style="margin-bottom:0px;">
  <table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
    <tr>
      <td colspan="2" align="center" bgcolor="#EBEBEB">會員註冊&nbsp;&nbsp;以下打“*”為必填</td>
    </tr>
    <tr>
      <td width="60" align="right" bgcolor="#FFFFFF">帳&nbsp;&nbsp;&nbsp;號:</td>
      <td width="317" bgcolor="#FFFFFF"><input name="member_user" type="text" id="member_user" size="20" maxlength="20" />
	  <font color="#FF0000"> *</font>(由數字或密碼組成)</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">密&nbsp;&nbsp;&nbsp;碼:</td>
      <td bgcolor="#FFFFFF"><input name="member_password" type="password" id="member_password" size="20" maxlength="20" />
      <font color="#FF0000"> *</font>(由數字或字母組成)</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">確認密碼:</td>
      <td bgcolor="#FFFFFF"><input name="pass" type="password" id="pass" size="20" />
      <font color="#FF0000"> *</font>(再次輸入密碼)</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">真實姓名:</td>
      <td bgcolor="#FFFFFF"><input name="member_name" type="text" id="member_name" size="20" />
      <label><font color="#FF0000">*</font></label></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">性&nbsp;&nbsp;&nbsp;别:</td>
      <td align="left" bgcolor="#FFFFFF">
          <input name="member_sex" type="radio" id="0" value="男" checked="checked" />
          男
          <input type="radio" name="member_sex" value="女" id="1" />
          女&nbsp;</label></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">連絡方式:</td>
      <td bgcolor="#FFFFFF"><input name="member_phone" type="text" id="member_phone" size="20"/></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">電子信箱:</td>
      <td bgcolor="#FFFFFF"><input name="member_email" type="text" id="member_email" size="20"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="reset" name="button" id="button" value="重置表單" />
      <input type="submit" name="submit" id="submit" value="確認註冊" /></td>
    </tr>
  </table>
</form>
<?php
} 
	if($_GET['tj']== ''){
?>
<?php
if($_POST["submit2"]){
$name=$_POST['name'];
$pw=md5($_POST['password']);
$sql="select * from member where member_user='".$name."'"; 
$result=mysql_query($sql) or die("帳號不正確");
$num=mysql_num_rows($result);
if($num==0){
	echo "<script>alert('帳號不存在');location='index.php';</script>";
	}
while($rs=mysql_fetch_object($result))
{
	if($rs->member_password!=$pw)
	{
		echo "<script>alert('密碼不正確');location='index.php';</script>";
		mysql_close();
	}
	else 
	{
		$_SESSION['member']=$_POST['name'];
		header("Location:member.php");
		mysql_close();
		}
	}
}
?>
<form action="" method="post" name="regform" onSubmit="return Checklogin();" style="margin-bottom:0px;">
<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td colspan="2" align="center" bgcolor="#EBEBEB" class="font">會員登入</td>
  </tr>
    <tr>
      <td width="65" align="center" bgcolor="#FFFFFF" class="font">用戶名:</td>
      <td width="262" bgcolor="#FFFFFF" class="font"><input name="name" type="text" id="name"></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFFF" class="font">密&nbsp;碼:</td>
      <td bgcolor="#FFFFFF" class="font"><input name="password" type="password" id="name">        </td>
    </tr>
    <tr>
    <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF" class="font"><input name="submit2" type="submit" value="會員登入"/>
      <a href='index.php?tj=register'>沒有帳號？立即註冊...</a></td>
  </tr>
</table>
</form>
<?php } ?>
<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>

</body>
</html>