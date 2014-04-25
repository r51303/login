<?php 
require_once ('config.php'); 
//判斷用戶權限
if(empty($_SESSION['member'])){
	echo "<script>alert('請進行登入或註冊');location='index.php';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員主頁面</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
//清除cookie登出
if($_GET["tj"]=="destroy"){
session_destroy();
echo "<script>alert('登出成功');location='index.php';</script>";}
?>
<?php
//用戶修改
if($_GET["tj"]=="modify") {
if($_POST["submit"]){
	mysql_query($sql="update member set member_name='".$_POST['member_name']."',member_phone='".$_POST['member_phone']."',member_email='".$_POST['member_email']."' where member_user='".$_SESSION['member']."'");
	echo "<script>alert('修改成功');location='member.php';</script>";
} ?>
<?php
//顯示用戶
$sql="select * from member where member_user='".$_SESSION['member']."'";
$rs=mysql_fetch_array(mysql_query($sql));
?>
<table width="350" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td align="center" bgcolor="#EBEBEB">修改信息&nbsp;&nbsp;<a href="member.php"> 進入主頁面</a></td>
  </tr>
</table>
<form method="post" action="" style="margin-top:3px; margin-bottom:3px;">
<table width="350" height="212" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td width="59" height="26" align="center" bgcolor="#FFFFFF">帳號：</td>
    <td width="268" align="left" bgcolor="#FFFFFF"><?php echo $rs['member_user'];?></td>
  </tr>
  <tr>
    <td height="28" align="center" bgcolor="#FFFFFF">姓名:</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_name" type="text" id="member_name" maxlength="20" value="<?php echo $rs['member_name'];?>"/></td>
  </tr>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF">性别：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $rs['member_sex'];?></td>
  </tr>
  <tr>
    <td height="33" align="center" bgcolor="#FFFFFF">手機號碼：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_phone" type="text" id="member_phone" value="<?php echo $rs['member_phone'];?>" maxlength="20"/></td>
  </tr>
  <tr>
    <td height="36" align="center" bgcolor="#FFFFFF">電子信箱：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_email" type="text" id="member_email" value="<?php echo $rs['member_email'];?>" maxlength="30"/></td>
  </tr>
  <tr>
    <td height="27" colspan="2" align="center" bgcolor="#FFFFFF"><input type="reset" name="button" id="button" value="重置" />
      <input type="submit" name="submit" id="submit" value="提交" /></td>
    </tr>
</table>
</form>
<?php } ?>
<?php
if($_SESSION['member'])                 
{?>
<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td width="327" align="center" bgcolor="#EBEBEB" class="font"><a href='?tj=destroy'>登出</a>&nbsp;&nbsp;<?php echo "<a href='?tj=modify'>修改個人資料</a>";?>  <?php if($_SESSION['member']=="admin"){?>
    <a href="admin_index.php">管理</a><?php }?></td>
  </tr>
</table>
<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>
<?php
$result=mysql_query("select * from member where member_user='".$_SESSION['member']."'"); 
while($rs=mysql_fetch_array($result)){
?>
<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td bgcolor="#FFFFFF">帳號:</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_user']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">姓名</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_name']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">性别</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_sex']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">手機號碼</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_phone']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">電子信箱</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_email']); ?></td>
  </tr>
</table>

<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>
<?php } 
}
?>
</body>
</html>