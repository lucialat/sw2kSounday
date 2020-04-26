<?php
require_once "config.php";
require_once 'Form.php';
require_once dirname(__DIR__) . "/classes/classes/song.php";
require_once dirname(__DIR__) . "/classes/classes/user.php";
require_once dirname(__DIR__) . "/classes/classes/album.php";
require_once dirname(__DIR__) . "/classes/factories/databaseFactory.php";

class FormularioBusqueda extends Form {
    private $opciones = array();

    public function __construct() {
        $this->opciones['action'] = "vistaBusqueda.php";
        parent::__construct("form-buscar", $this->opciones);
    }

    protected function generaCamposFormulario($datosIniciales, $err) {
        $html = "";
        if (isset($datosIniciales['busqueda'])) {
            $html .= '<input type = "search" name = "busqueda" value="'.$datosIniciales['busqueda'].'" placeholder = "Buscar artistas, canciones o álbumes" >';
        }
        else $html.= '<input type = "search" name = "busqueda" placeholder = "Buscar artistas, canciones o álbumes" >';
        $html .= '<input type = "submit" name = "Buscar" value = "Buscar" >';
        $html .= $err;
        return $html;
    }

    protected function procesaFormulario($datos) {
        $resultado = array();

        assert(is_string($_POST['busqueda']), "Error al introducir los datos");
        $buscar = htmlspecialchars(trim(strip_tags($datos['busqueda'])));
        $canciones = song::buscar($buscar);
        $artistas = user::buscar($buscar);
        $albumes = album::buscar($buscar);

        $html = "";
        if ($canciones == null && $artistas == null && $albumes == null) $resultado[] = "<p>No existen resultados para su búsqueda.</p>";
        else {
            if ($canciones != null){
                $html.= "<h1>CANCIONES</h1>";
                foreach ($canciones as $cancion) {
                    $html.= '<div>';
                    $html.= '<h3>' . $cancion->getTitle() . '</h3><p>Autor: ' . (user::buscaUsuarioId($cancion->getIdUser()))->getName() . '</p><p>Album: ' . (album::buscaAlbumId($cancion->getIdAlbum()))->getTitle() . '</p>';
                    $html.= '<audio src="server/songs/' . $cancion->getId()  . '.mp3" type="audio/mpeg" controls>Tu navegador no soporta el audio</audio>';
                    $html.= '</div>';
                }
            }

            if ($artistas != null) {
                $html.= "<h1>ARTISTAS</h1>";
                foreach ($artistas as $artista) {
                    $html.= '<div>';
                    $html.= '<h3>' . $artista->getName() . '</h3><p>Descripción: ' . $artista->getDescripcion() . '</p>';
                    $html.= '</div>';
                }
            }

            if ($albumes != null){
                $html.= "<h1>ALBUMES</h1>";
                foreach ($albumes as $album) {
                    $html.= '<div>';
                    $html.= '<h3>' . $album->getTitle() . '</h3><p>Año de lanzamiento: ' . $album->getReleaseDate() . '</p>';
                    $html.= '</div>';
                }
            }
        }
        $resultado[] = $html;

        return $resultado;
    }
}