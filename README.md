# AV-SALES
Módulo de listagem de pedidos para sistema DataGold

O módulo é baseado em 'abas' e deve ser ajustado parametro de acesso ao banco em 'oci_ped.php'

```
    include 'c:/web/www/global/oci.php';
```

'oci.php' deve fornecer uma conexão com o banco.

bem como uma função de consulta:

```
 public function select($query)
{
    $conn = $this->conn;
    return ($conn->query($query));
}
```
