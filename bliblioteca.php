<?php
include('config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');
header('ContentType:application/json; charset=utf-8');
$post = json_decode(file_get_contents("php://input"), true);


if ($post['accion']=='listar'){
    $sentecia = sprintf("Select * from libro");
    $rs=mysqli_query($mysqli, $sentecia);
    if (mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array(result: $rs)){
            $datos[] = array(
                'idlibro' =>  $row['idlibro'],
                'titulo' => $row['titulo'],
                'autor' => $row['autor'],
                'genero' => $row['genero']
            );
        }
        $respuesta = json_encode(array('estado'=>true, 'libro'=>$datos));
    }else{
        $respuesta = json_encode(array('estado'=>false, 'mensaje'=>"Error no exite libros"));
    }
    echo $respuesta;
}

if ($post['accion']=='vnombre')
{
    $sentecia=sprintf("select idlibro from libro where titulo='%s'",$post['titulo']);
    $rs=mysqli_query($mysqli,$sentecia);
    if (mysqli_num_rows($rs)>0){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"El libro ya  existente en el sistema"));
    }else{
        $respuesta = json_encode(array('estado'=>false));
    }
    echo $respuesta;
}

if ($post['accion']=='glibro')
{
    $sentecia=sprintf("INSERT INTO libro(titulo,autor, genero)  VALUES ('%s','%s','%s')",$post['titulo'], $post['autor'], $post['genero']);
    $rs=mysqli_query($mysqli,$sentecia);
    if ($rs){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"datos guardados"));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error'));
    }
    echo $respuesta;
}

if ($post['accion']=='dlibro')
{
    $sentecia=sprintf("select * from libro where idlibro='%s'",$post['idlibro']);
    $rs=mysqli_query($mysqli,$sentecia);
    if (mysqli_num_rows($rs)>0){
        $row = mysqli_fetch_assoc(result:$rs);
        $datos = array(
           'codigo' =>  $row['idlibro'],
            'titulo' => $row['titulo'],
            'autor' => $row['autor'],
            'genero' => $row['genero']
        );
        $respuesta = json_encode(array('estado'=>true,'libro'=>$datos));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Datos no encontrados'));
    }
    echo $respuesta;
}

if ($post['accion']=='alibro')
{
    $sentecia=sprintf("UPDATE libro SET titulo='%s',autor='%s',genero='%s' WHERE idlibro='%s' " ,$post['titulo'], $post['autor'], $post['genero'], $post['idlibro']);
    $rs=mysqli_query($mysqli,$sentecia);
    if ($rs){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"datos actulizados"));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error al actualizar'));
    }
    echo $respuesta;
}
if ($post['accion']=='elibro')
{
    $sentecia=sprintf("DELETE FROM libro where idlibro='%s'", $post['idlibro']);
    $rs=mysqli_query($mysqli,$sentecia);
    if ($rs){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"Dato eliminado correctamente"));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error no se elimino'));
    }
    echo $respuesta;
}


if ($post['accion']=='cresena')
{
    $sentecia=sprintf("Select * from resena where  idlibro='%s'",$post['idlibro']);
    $rs=mysqli_query($mysqli,$sentecia);
    if (mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array(result: $rs)){
            $datos[] = array(
                'idresena' =>  $row['idresena'],
                'calificacion' =>  $row['calificacion'],
                'comentario' =>  $row['comentario'],
                'usuario' =>  $row['usuario'],
                'idlibro' =>  $row['idlibro']
            );
        }
        $respuesta = json_encode(array('estado'=>true,'resena'=>$datos));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'No existe regitros'));
    }
    echo $respuesta;
}

if ($post['accion']=='nuevoresena')
{
    $sentecia=sprintf("INSERT INTO resena (idlibro, calificacion, comentario, usuario) VALUES ('%s','%s','%s','%s')",$post['idlibro'], $post['calificacion'], $post['comentario'], $post['usuario']);
    $rs=mysqli_query($mysqli,$sentecia);
    if ($rs){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"datos guardados"));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error'));
    }
    echo $respuesta;
}

if ($post['accion']=='dresena')
{
    $sentecia=sprintf("select * from resena where idresena=%s",$post['idresena']);
    $rs=mysqli_query($mysqli,$sentecia);
    if (mysqli_num_rows($rs)>0){
        $row = mysqli_fetch_assoc(result:$rs);
        $dato = array(
            'idresena' =>  $row['idresena'],
            'calificacion' =>  $row['calificacion'],
            'comentario' => $row['comentario'],
            'usuario' => $row['usuario'],
            'idlbro' => $row['idlibro']
        );
        $respuesta = json_encode(array('estado'=>true,'resena'=>$dato));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Datos no encontrados'));
    }
    echo $respuesta;
}

if ($post['accion']=='aresena')
{
    $sentecia=sprintf("UPDATE resena SET calificacion='%s',comentario='%s' ,usuario='%s' WHERE idresena='%s' " , $post['calificacion'], $post['comentario'], $post['usuario'],$post['idresena']);
    $rs=mysqli_query($mysqli,$sentecia);
    if ($rs){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"datos actulizados"));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error al actualizar'));
    }
    echo $respuesta;
}

if ($post['accion']=='eliminar')
{
    $sentecia=sprintf("DELETE FROM resena where idresena='%s'", $post['idresena']);
    $rs=mysqli_query($mysqli,$sentecia);
    if ($rs){
        $respuesta = json_encode(array('estado'=>true,'mensaje'=>"Dato eliminado correctamente"));
    }else{
        $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error no se elimino'));
    }
    echo $respuesta;
}



?>