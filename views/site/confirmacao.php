<?php
$this->title = "Confirmação de Senha";
?>
<section>
    <h2 class="titulo">
        Software de Controle e Gerenciamento de Trabalho de Conclusão de Curso
   </h2>
</section>
   <div class="row">
       <section class="col-md-10 col-md-offset-1">
        <div id="painel-login">
      <div class="panel panel-login">
        <div class="panel-body">
            <div class="row" style="padding: 30px;">
              <div class="col-lg-3">
                  <img src="../../web/imagem/ok.png" alt="" class="img-responsive"/>
              </div>
              <div class="col-lg-9 text-center">
                  <h3>Olá, <?php echo $cadastro->nome; ?></h3>
                  <p>Seu cadastro foi realizado com sucesso, a nossa próxima etapa será a confirmação dos seus dados na <strong>secretária educacional</strong>.</p>
                  <p>Aguarde, logo você receberá a confirmação no seu e-mail:<br>
                  <p><a href="mailto:<?php echo $cadastro->email; ?>"><strong><?php echo $cadastro->email; ?></strong></a></p>
                
                  <p>Qualquer dúvida entre em contato <a href="/contato">conosco</a></p>
              </div>
          </div>
        </div>
      </div>
        </div>
       </section>
   </div>


