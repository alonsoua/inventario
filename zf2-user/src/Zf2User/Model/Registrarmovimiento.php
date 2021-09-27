<?php
namespace Zf2User\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;

class Registrarmovimiento 
{
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function insertarIngresoUsuario($idUsuario,$urlUbicacion,$metodoEnvio)
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert('registro_movimiento');
        $newData = array(
            'user_perfil_id'=> $idUsuario,
            'url'=> $urlUbicacion,
            'metodo_envio'=> $metodoEnvio,
        );
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }
}
            
