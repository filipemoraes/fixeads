Configurações necessárias:

- MySql 5+
- PHP 5.6+
- Habilitar o driver PDO e o driver referente ao banco utilizado, no caso MySQL
- Habilitar o mod_rewrite do Apache

É necessário criar a base de dados manualmente.
Na raiz do projeto encontra-se o ficheiro "bd.sql" necessário.
Após criar a base de dados, é necessário editar o ficheiro "config.ini" na raiz do projeto:

#config.ini
-------------------
db = MySQL
dbname = fixeads
username = 'root'
passwd = 'root'
host = localhost
debug = true
-------------------

O parâmetro "debug" indica se as mensagens de erro devem ser exibidas em tela.
