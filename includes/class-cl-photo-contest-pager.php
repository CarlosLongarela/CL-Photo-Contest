<?php
/**
 *
 * Archivo paginador.class.php
 * Codificacion UTF-8
 * Identacion de tabulador (4 espacios)
 * Sin acentos
 *
 * @author Carlos Longarela
 * @version 0.1 Feb 2005
 * @version 1.2 Feb 2009
 * @version 1.3 Feb 2013
 * @version 1.4 Ago 2013
 * @version 1.5 Mar 2017
 *
 */

class Pager {
//*************************************************************
//********************** VARIABLES ****************************
//*************************************************************
	private $n_registros   = 0; // Número de registros totales.
	private $n_mostrar     = 10; // Número de registros a mostrar en cada pagina.
	private $items_por_pag = 10; // Número de items de paginas mostrados en cada visualizacion.
	private $num_pags      = 0; // Número de paginas que hay con los registros actuales, calculado en el constructor.
	private $pag_actual    = 1; // Número de pagina en la que estamos.
	private $ruta_base     = ''; // Ruta base de la pagina.

	// Cadenas de Texto para la navegación.
	private $primera   = '|&lt;';
	private $anterior  = '&nbsp;&laquo;';
	private $siguiente = '&raquo;&nbsp;';
	private $ultima    = '&gt;|';
	private $mas_links = '...';
	private $ini_links = '...';

	private $slug_pags = '?id_pag=';

	public $class_desactivado = 'desactivado';
	public $enl_pags          = 'enl_pags';
	public $pag_act           = 'pag_act';

//*******************************************************************
//****************************  PUBLICOS ****************************
//*******************************************************************
	/**
	 * Constructor de la clase paginador
	 */
	public function __construct( $ruta_base, $n_registros, $n_mostrar = 10, $items_por_pag = 10 ) {
		//parent::__construct();

		$this->n_registros   = $n_registros;
		$this->n_mostrar     = $n_mostrar;
		$this->items_por_pag = $items_por_pag;
		$this->ruta_base     = $ruta_base;

		$this->num_pags = ceil( $this->n_registros / $n_mostrar);

		//if (strstr($this->archivo,'?')) $this->arg_ini='&amp;';

		if ( ! empty( $_GET['id_pag'] ) ) {
			$this->pag_actual = $_GET['id_pag'];
		}
	} // Fin del constructor.

	public function __destruct() {
		parent::__destruct();
	}//fin destructor

	public function set_slug_pags($slug) {
		$this->slug_pags = $slug;
	}//fin set_slug_pags

	//---------------------------------------
	// Fija la pagina actual a la indicada
	//---------------------------------------
	public function set_pag_actual($pag) {
		$this->pag_actual = $pag;
	}//fin set_pag_actual

 	//----------------------------------------------------------
	// Muestra Enlace a la Primera Pagina y a la Pagina Anterior
	//----------------------------------------------------------
	public function atras() {
		$html='';
		if ($this->pag_actual==1) {
			$html.='<span class="'.$this->class_desactivado.'">'.$this->primera.$this->anterior.'</span>';
		}else{
			$html.='<a href="'.$this->ruta_base.'" class="'.$this->enl_pags.'">'.$this->primera.'</a>';
			if (($this->pag_actual - 1)==1){//Si es la primera pagina
				$html.='<a href="'.$this->ruta_base.'" class="'.$this->enl_pags.'">'.$this->anterior.'</a>';
			}else{
				$html.='<a href="'.$this->ruta_base.$this->slug_pags.($this->pag_actual-1).'" class="'.$this->enl_pags.'">'.$this->anterior.'</a>';
			}//if
		}//if

		return $html;
	}//fin atras

	//----------------------------------------------------------
	// Muestra Enlace a la ultima Pagina y a la Pagina Siguiente
	//----------------------------------------------------------
	public function adelante()	{
		$html='';
		if ($this->pag_actual==$this->num_pags) {
			$html.='<span class="'.$this->class_desactivado.'">'.$this->siguiente.$this->ultima.'</span>';
		}else{
			$html.='<a href="'.$this->ruta_base.$this->slug_pags.($this->pag_actual + 1).'" class="'.$this->enl_pags.'">'.$this->siguiente.'</a>';
			$html.='<a href="'.$this->ruta_base.$this->slug_pags.$this->num_pags.'" class="'.$this->enl_pags.'">'.$this->ultima.'</a>';
		}//if

		return $html;
	}//fin adelante

	//---------------------------------------------------------
	// Muestra Enlaces a cada una de las paginas de navegacion
	//---------------------------------------------------------
	public function crea_barra_pags() {
		$num_pags		= $this->num_pags;
		$items_por_pag	= $this->items_por_pag;
		$inicio			= 1;
		$html			= '';

		for ( $i = 1; $i <= $num_pags; $i += $items_por_pag ) {
			if ( $this->pag_actual >= $i ) {
				$inicio = $i;
			}
		}//for

		$fin = $inicio + $items_por_pag - 1;

		if ( $fin > $num_pags ) {
			$fin = $num_pags;
		}//if


		if ( $inicio > 1 ) {
			$pos = $inicio - 1;
			$html .= '<a href="' . $this->ruta_base . $this->slug_pags . $pos . '" class="' . $this->enl_pags . '">' . $this->ini_links . '</a>';
		}//if

		for ( $i = $inicio; $i <= $fin; $i++ ) {
			if ( $this->pag_actual == $i || ( $this->pag_actual == 0 && $i == 1 ) ) {
				$html .= '<span class="' . $this->pag_act . '">' . $i . '</span>';
			} else {
				if ( $i == 1 ) {
					$html .= '<a href="' . $this->ruta_base . '" class="' . $this->enl_pags . '">' . $i . '</a>';
				} else {
					$html .= '<a href="' . $this->ruta_base . $this->slug_pags . $i . '" class="' . $this->enl_pags . '">' . $i . '</a>';
				}//if
			}//if
		}//for

		if ( $fin < $num_pags ) {
			$html .= '<a href="' . $this->ruta_base . $this->slug_pags . $i . '" class="' . $this->enl_pags . '">' . $this->mas_links . '</a>';
		}//if

		return $html;
	}//fin crea_barra_pags

	//---------------------------------------
	// Muestra el numero de pagina actual y
	// el numero de paginas totales
	//---------------------------------------
	public function muestra_num_pag() {
		$html = 'P&aacute;gina&nbsp;' . $this->pag_actual . '&nbsp;de&nbsp;' . $this->num_pags;
		return $html;
	}//fin muestra_num_pag

	//----------------------------------------------------------
	// Muestra la barra de Navegacion con las opciones de ir:
	// al primer registro, al anetrior
	// navegar por las paginas,
	// ir al siguiente e ir al ultimo
	//----------------------------------------------------------
	public function barra_naveg() {
		$html = '';

		$html .= $this->atras();
		$html .= $this->crea_barra_pags();
		$html .= $this->adelante();

		return $html;
	}//fin barra_naveg

}
