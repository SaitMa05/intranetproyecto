<?php

class User{

    private $id;
    private $nombre;
    private $apellido;
    private $nombreUsuario;
    private $dni;
    private $telefono;
    private $email;
    private $password;
    private $aceptado;
    private $fechaCreacion;
    private $fechaModificacion;
    private $fechaEliminacion;
    private $creadorPor;
    private $modificadoPor;
    private $eliminadoPor;
    private $aceptadoPor;
    private $fkRol;


	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id 
	 * @return self
	 */
	public function setId($id): self {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getNombre() {
		return $this->nombre;
	}
	
	/**
	 * @param mixed $nombre 
	 * @return self
	 */
	public function setNombre($nombre): self {
		$this->nombre = $nombre;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getApellido() {
		return $this->apellido;
	}
	
	/**
	 * @param mixed $apellido 
	 * @return self
	 */
	public function setApellido($apellido): self {
		$this->apellido = $apellido;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getNombreUsuario() {
		return $this->nombreUsuario;
	}
	
	/**
	 * @param mixed $nombreUsuario 
	 * @return self
	 */
	public function setNombreUsuario($nombreUsuario): self {
		$this->nombreUsuario = $nombreUsuario;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getDni() {
		return $this->dni;
	}
	
	/**
	 * @param mixed $dni 
	 * @return self
	 */
	public function setDni($dni): self {
		$this->dni = $dni;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getTelefono() {
		return $this->telefono;
	}
	
	/**
	 * @param mixed $telefono 
	 * @return self
	 */
	public function setTelefono($telefono): self {
		$this->telefono = $telefono;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * @param mixed $email 
	 * @return self
	 */
	public function setEmail($email): self {
		$this->email = $email;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * @param mixed $password 
	 * @return self
	 */
	public function setPassword($password): self {
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getAceptado() {
		return $this->aceptado;
	}
	
	/**
	 * @param mixed $aceptado 
	 * @return self
	 */
	public function setAceptado($aceptado): self {
		$this->aceptado = $aceptado;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getFechaCreacion() {
		return $this->fechaCreacion;
	}
	
	/**
	 * @param mixed $fechaCreacion 
	 * @return self
	 */
	public function setFechaCreacion($fechaCreacion): self {
		$this->fechaCreacion = $fechaCreacion;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getFechaModificacion() {
		return $this->fechaModificacion;
	}
	
	/**
	 * @param mixed $fechaModificacion 
	 * @return self
	 */
	public function setFechaModificacion($fechaModificacion): self {
		$this->fechaModificacion = $fechaModificacion;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getFechaEliminacion() {
		return $this->fechaEliminacion;
	}
	
	/**
	 * @param mixed $fechaEliminacion 
	 * @return self
	 */
	public function setFechaEliminacion($fechaEliminacion): self {
		$this->fechaEliminacion = $fechaEliminacion;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCreadorPor() {
		return $this->creadorPor;
	}
	
	/**
	 * @param mixed $creadorPor 
	 * @return self
	 */
	public function setCreadorPor($creadorPor): self {
		$this->creadorPor = $creadorPor;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getModificadoPor() {
		return $this->modificadoPor;
	}
	
	/**
	 * @param mixed $modificadoPor 
	 * @return self
	 */
	public function setModificadoPor($modificadoPor): self {
		$this->modificadoPor = $modificadoPor;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getEliminadoPor() {
		return $this->eliminadoPor;
	}
	
	/**
	 * @param mixed $eliminadoPor 
	 * @return self
	 */
	public function setEliminadoPor($eliminadoPor): self {
		$this->eliminadoPor = $eliminadoPor;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getAceptadoPor() {
		return $this->aceptadoPor;
	}
	
	/**
	 * @param mixed $aceptadoPor 
	 * @return self
	 */
	public function setAceptadoPor($aceptadoPor): self {
		$this->aceptadoPor = $aceptadoPor;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getFkRol() {
		return $this->fkRol;
	}
	
	/**
	 * @param mixed $fkRol 
	 * @return self
	 */
	public function setFkRol($fkRol): self {
		$this->fkRol = $fkRol;
		return $this;
	}
}