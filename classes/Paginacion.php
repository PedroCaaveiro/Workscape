<?php

namespace Classes;


class Paginacion{

    public $pagina_actual;
    public $registros_X_pagina;
    public $total_registros;


public function __construct($pagina_actual = 1,$registros_X_pagina = 10,$total_registros = 0){

    $this->pagina_actual = (int) $pagina_actual;
    $this->registros_X_pagina = (int) $registros_X_pagina; 
    $this->total_registros = (int) $total_registros; 

}

public function offset(){

    return $this->registros_X_pagina *($this->pagina_actual - 1);
}

public function total_paginas() {
    return ceil($this->total_registros / $this->registros_X_pagina);
}

public function paginaAnterior() {
    $anterior = $this->pagina_actual - 1;
    return ($anterior >= 1) ? $anterior : false;
}

public function numerosPaginas(){
    $html = '';
    for ($i = 1; $i <= $this->total_paginas(); $i++) { 
        if ($i == $this->pagina_actual) {
            $html .= "<span class=\"paginacion__actual\">$i</span>";
        } else {
            $html .= "<a class=\"paginacion__enlace\" href=\"?page=$i\">$i</a>";
        }
    }
    return $html;
}


public function paginaSiguiente() {
    $siguiente = $this->pagina_actual + 1;
    return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
}

public function enlaceAnterior() {
    $html = '';
    if ($this->paginaAnterior()) {
        $html .= '<a class="paginacion__enlace" href="?page=' . $this->paginaAnterior() . '">&laquo; Anterior</a>';
    }
    return $html;
}

public function enlaceSiguiente() {
    $html = '';
    if ($this->paginaSiguiente()) {
        $html .= '<a class="paginacion__enlace" href="?page=' . $this->paginaSiguiente() . '">Siguiente &raquo;</a>';
    }
    return $html;
}

public function paginacion() {
    $html = '';
    if ($this->total_paginas() > 1) {
        $html .= '<div class="paginacion">';
        $html .= $this->enlaceAnterior();
        $html .= $this->numerosPaginas();
        $html .= $this->enlaceSiguiente();
        $html .= '</div>';
    }
    return $html;
}


}