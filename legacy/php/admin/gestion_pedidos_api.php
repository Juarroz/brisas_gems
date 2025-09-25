<?php
require_once '../conexion.php';
require_once 'PedidoProduccionModel.php';
session_start();

$model = new PedidoProduccionModel($conn);

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
$response = ['success' => false, 'msg' => 'Acción no válida'];

switch ($accion) {
    case 'subir_render':
        if (!empty($_FILES['render_file']['name']) && isset($_POST['ped_id'])) {
            $ext = strtolower(pathinfo($_FILES['render_file']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['obj', 'stl'])) {
                $response['msg'] = 'Formato no permitido.';
                break;
            }
            $ruta = '../../uploads/renders/pedido_' . intval($_POST['ped_id']) . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['render_file']['tmp_name'], $ruta)) {
                $ok = $model->guardarRender3D(intval($_POST['ped_id']), $ruta);
                $response = $ok ? ['success' => true] : ['success' => false, 'msg' => 'Error al guardar en BD'];
            } else {
                $response['msg'] = 'Error al subir archivo.';
            }
        }
        break;
    case 'subir_imagen_final':
        if (!empty($_FILES['img_file']['name']) && isset($_POST['ped_id'])) {
            $ext = strtolower(pathinfo($_FILES['img_file']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $response['msg'] = 'Formato no permitido.';
                break;
            }
            $ruta = '../../uploads/finales/pedido_' . intval($_POST['ped_id']) . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['img_file']['tmp_name'], $ruta)) {
                $ok = $model->guardarImagenFinal(intval($_POST['ped_id']), $ruta);
                $response = $ok ? ['success' => true] : ['success' => false, 'msg' => 'Error al guardar en BD'];
            } else {
                $response['msg'] = 'Error al subir archivo.';
            }
        }
        break;
    case 'guardar_comentario':
        if (isset($_POST['ped_id'], $_POST['comentario'])) {
            $ok = $model->guardarComentario(intval($_POST['ped_id']), $_POST['comentario']);
            $response = $ok ? ['success' => true] : ['success' => false, 'msg' => 'Error al guardar comentario'];
        }
        break;
    case 'actualizar_estado':
        if (isset($_POST['ped_id'], $_POST['est_id'])) {
            $ok = $model->actualizarEstado(intval($_POST['ped_id']), intval($_POST['est_id']));
            $response = $ok ? ['success' => true] : ['success' => false, 'msg' => 'Error al actualizar estado'];
        }
        break;
    default:
        $response['msg'] = 'Acción no reconocida.';
}
header('Content-Type: application/json');
echo json_encode($response);
