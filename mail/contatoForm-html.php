<style type="text/css">
    table{
        font-size:12px;
    }
    
</style>    
<table id="email" width="540" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td colspan="3">Contato enviado no dia: <?php echo date("d/m/Y H:i:s");?></td>
    </tr>
    <tr><td colspan="3"><h1>Contato Realizado pelo Site</h1></td></tr>
    <tr><td style="text-align:right; width: 100px; font-weight: bold;">Nome: </td><td colspan="2"><?php echo $contatoForm->nome; ?></td></tr>
    <tr><td style="text-align:right;width: 100px; font-weight: bold;">E-mail: </td><td colspan="2"><?php echo $contatoForm->email; ?></td></tr>
    <tr><td style="text-align:right;width: 100px; font-weight: bold;">Telefone: </td><td colspan="2"><?php echo $contatoForm->telefone; ?></td></tr>
    <tr><td style="text-align:right;width: 100px; font-weight: bold;">Celula: </td><td colspan="2"><?php echo $contatoForm->celular; ?></td></tr>
    <tr><td style="text-align:right;width: 100px; font-weight: bold;">Assunto: </td><td colspan="2"><?php echo $contatoForm->assunto; ?></td></tr>
    <tr><td style="text-align:right;width: 100px; font-weight: bold;">Mensagem: </td><td colspan="2"><?php echo $contatoForm->descricao; ?><br><br><br></td></tr>
    
</table>