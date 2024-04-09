<div class="container">

<h1>Logger</h1>

<p>O Logger é uma classe PHP para registrar logs em arquivos e exibir mensagens no terminal.</p>

<h2>Funcionalidades</h2>

<ul>
  <li>Espaços no nome do arquivo serão alterados para underscores "_".</li>
  <li>Ao instanciar a classe, é possível passar um array de configuração (opcional) com os seguintes elementos:
    <ul>
      <li><code>path</code>: Caminho onde os arquivos serão salvos. Se não for informado, o padrão é <code>./logs</code>.</li>
      <li><code>nameFile</code>: Nome dos arquivos. Se não for informado, o padrão é <code>log_%d[Ymd].log</code>.</li>
      <li><code>messageFormat</code>: Formato da mensagem que será gravada no arquivo. Se não for informado, o padrão é <code>[%d[d/m/Y H:i:s]] [%u]] [%t] %m %</code>.
        <ul>
          <li><code>%d</code>: Data atual em formato Y-m-d [Y-m-d H:i:s], seguindo o padrão do formato da função <code>date</code>.
            <ul>
              <li><code>%d[format]</code>: Data atual com o formato especificado.</li>
            </ul>
          </li>
          <li><code>%u</code>: Identificador único gerado a cada requisição do Logger.</li>
          <li><code>%t</code>: Tipo do log, podendo ser INFO, ERROR, etc. Se nenhum for enviado, será considerado como INFO.</li>
        </ul>
      </li>
    </ul>
  </li>
</ul>

<h2>Chamada da Função</h2>

<pre>
$logger = Logger($configuracao); //$configuração é um campo opcional
$logger->log("Mensagem Teste", 2); // Será gerado um arquivo de acordo com as configurações
$logger->printToTerminal("Mensagem Teste", 1); // Irá exibir no terminal
</pre>

<p><strong>Exemplo de Utilização:</strong></p>

<pre>
// Exemplo de utilização do Logger
$configuracao = [
    'path' => '/caminho/do/logs',
    'nameFile' => 'meu_log_%d[Ymd].log',
    'messageFormat' => '[%d[d/m/Y H:i:s]] [%t] %m %u'
];

$logger = Logger($configuracao);
$logger->log("Mensagem de teste", 2);  // pode ser utilizado tambem a string "error" $logger->log("Mensagem de teste", "error"); 
</pre>

<h2>Configurações Padrão</h2>

<p>Se as configurações não forem fornecidas ao instanciar a classe, valores padrão serão utilizados para o caminho do arquivo de log, nome do arquivo e formato da mensagem.</p>

<h2>Formatação da Data</h2>

<p>É possível formatar a data conforme desejado pelo usuário, usando o marcador <code>%d[format]</code>. Exemplos:</p>

<pre>
$d[y] - ano com dois digitos
$d[Y] - ano completo
$d[m] - mês com dois dígitos
$d[M] - mês completo
$d[d] - dia com dois dígitos
$d[Ymd] - data no formato AAAAMMDD
$d[Y-m-d H:i:s] - Data e hora no formato AAAA-MM-DD HH:mm:ss
</pre>

<h2>Tipos de Logs</h2>

<p>A mensagem na chamada da função <code>log()</code> e <code>printToTerminal()</code> podem ser do tipo string, inteiro, float, array, boolean</p>
<p>boollen true será mostrado 1 e boolean false será vazio</p>

<p>O tipo de log é opcional na chamada da função <code>log()</code> e <code>printToTerminal()</code>.. Caso não seja informado, ele assume que é um LOG INFO. Os tipos de logs suportados são: INFO, DEBUG, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY.</p>

<h2>Padrão Singleton</h2>

<p>O Logger foi desenvolvido seguindo o padrão de projeto Singleton. Isso garante que apenas uma instância da classe seja criada durante a execução do programa, o que pode trazer as seguintes vantagens:</p>

<ul>
  <li>Economia de memória: Apenas uma instância da classe é mantida em memória, mesmo que seja acessada várias vezes.</li>
  <li>Controle de acesso global: O acesso à instância única do Logger é facilitado em todo o código, garantindo consistência e evitando problemas de concorrência.</li>
  <li>Facilidade de manutenção: O Singleton promove um design claro e conciso, facilitando a manutenção e a compreensão do código.</li>
</ul>

</div>


