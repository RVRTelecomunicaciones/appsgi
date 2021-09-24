<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    function buscarPermisoLectura($menu, $obj) {

        if (!empty($obj)) {
            foreach ($obj as $row) {
                if ($menu == $row->menu_id)
                    return $row->permiso_lectura;
            }
        }
    }

    function buscarPermisoEscritura($menu, $obj) {

        if (!empty($obj)) {
            foreach ($obj as $row) {
                if ($menu == $row->menu_id)
                    return $row->permiso_escritura;
            }
        }
    }