 <?php
if(!defined('WY_ROOT')) exit;
?>
<div id="main_content">
<table class="table_base table_list">
	<tr>
    	<th class="right">服务器系统：</th>
        <td class="bold left"><?php echo php_uname() ?></td>
    </tr>
    
	<tr>
    	<th class="right">PHP版本号：</th>
        <td class="bold left"><?php echo phpversion() ?></td>
    </tr>
    
	<tr>
    	<th class="right">后台路径：</th>
        <td class="bold left"><?php echo dirname(__FILE__) ?></td>
    </tr>
    
	<tr>
    	<th class="right">服务器语言：</th>
        <td class="bold left"><?php echo _S('HTTP_ACCEPT_LANGUAGE') ?></td>
    </tr>
	<tr>
	  <th class="right">PHP安装路径：</th>
	  <td class="bold left"><?php echo DEFAULT_INCLUDE_PATH ?></td>
  </tr>
	<tr>
	  <th class="right">服务器IP：</th>
	  <td class="bold left"><?php echo GetHostByName(_S('HTTP_HOST')) ?></td>
  </tr>
	<tr>
	  <th class="right">PHP运行方式：</th>
	  <td class="bold left"><?php echo php_sapi_name() ?></td>
  </tr>
	<tr>
	  <th class="right">文档主目录：</th>
	  <td class="bold left"><?php echo _S('DOCUMENT_ROOT') ?></td>
  </tr>
	<tr>
	  <th class="right">进程用户名：</th>
	  <td class="bold left"><?php echo get_current_user() ?></td>
  </tr>
	<tr>
	  <th class="right">服务器WEB端口：</th>
	  <td class="bold left"><?php echo _S('SERVER_PORT') ?></td>
  </tr>
	<tr>
	  <th class="right">ZEND版本号：</th>
	  <td class="bold left"><?php echo zend_version() ?></td>
  </tr>
	<tr>
	  <th class="right">服务器系统目录：</th>
	  <td class="bold left"><?php echo _S('SystemRoot') ?></td>
  </tr>

</table>
</div>