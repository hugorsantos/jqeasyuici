<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Basic CRUD Application - jQuery EasyUI CRUD Demo and CodeIgniter</title>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.easyui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/demo.css">
        
        <script type="text/javascript">
            var url;
			//funcao utilizada para abrir a janela de incluir novo registro
            function newUser(){
                $('#dlg').dialog('open').dialog('setTitle','New User');
                $('#fm').form('clear');
                url = 'index.php/agenda/setInsert';
				msg = 'Registro incluido com sucesso!';            
			}
			
			//utilizado para abrir a tela para alterar o registro
            function editUser(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $('#dlg').dialog('open').dialog('setTitle','Edit User');
                    $('#fm').form('load',row);
					//$('#cpid').val(row.id);
                    url = 'index.php/agenda/setUpdate/'+row.id;
					msg = 'Registro alterado com sucesso!'; 
                }
            }
            
			//funcao utilizada tanto para salvar como incluir registro
            function saveUser(){
                $('#fm').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        var result = eval('('+result+')');
                        if (result.success){   
								$.messager.alert('Exclus&atilde;o',msg);                        
								$('#dlg').dialog('close');        // close the dialog
                            	$('#dg').datagrid('reload');    // reload the user data 
                        } else {
							$.messager.show({
								title: 'Error',
								msg: result.errorMsg
							});
                        }
                    }
                });
            }
			
			//funcao que exclui o registro do banco de dados
            function destroyUser(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Voc&ecirc; tem certeza que quer excluir este usu&aacute;rio?',function(r){
                        if (r){
                            $.post('index.php/agenda/setDelete/'+row.id,function(result){
                                if (result.success){
									$.messager.alert('Exclus&atilde;o','Registro excl&iacute;do com sucesso!');
                                    $('#dg').datagrid('reload');    // reload the user data
                                } else {
                                    $.messager.show({    // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            },'json');
                        }
                    });
                }
            }
        </script>
        
        <style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
        </style>
        
    </head>
    <body>
        <h2>Basic CRUD Application</h2>
        <div class="demo-info" style="margin-bottom:10px">
            <div class="demo-tip icon-tip">&nbsp;</div>
            <div>Click the buttons on datagrid toolbar to do crud actions.</div>
        </div>

        <table id="dg" title="My Users" class="easyui-datagrid" style="width:700px;height:365px"
        url="index.php/agenda/getListagem"
        toolbar="#toolbar" pagination="true"
        rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="nome" width="50">NOME</th>
                    <th field="email" width="50">EMAIL</th>
                    <th field="telefone" width="50">TELEFONE</th>
                    <th field="celular" width="50">CELULAR</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove User</a>
        </div>

        <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
            <div class="ftitle">User Information</div>
            <form id="fm" method="post" novalidate>            	
                <div class="fitem">
                    <label>Nome:</label>
                    <input name="nome" id="nome" class="easyui-validatebox" required>
                </div>
                <div class="fitem">
                    <label>E-MAIL:</label>
                    <input name="email"  id="email"  class="easyui-validatebox" validType="email">
                </div>
                    <div class="fitem">
                    <label>TELEFONE:</label>
                    <input name="telefone" id="telefone" class="easyui-validatebox" required>
                </div>
                <div class="fitem">
                <label>CELULAR:</label>
                <input name="celular" id="celular" class="easyui-validatebox" required>
                </div>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Save</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
        </div>

    </body>
</html>