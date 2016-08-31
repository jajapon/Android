package com.chiralcode.colorpicker;

public class Bloque {

	int posicion=0;
	int rojo=0;
	int verde=0;
	int azul=0;
	
	public Bloque(){
		
	}
	public Bloque(int posicion,int rojo, int verde,int azul){
		posicion = this.posicion;
		rojo = this.rojo;
		verde = this.verde;
		azul = this.azul;
	}
	public int getPosicion() {
		return posicion;
	}
	public void setPosicion(int posicion) {
		this.posicion = posicion;
	}
	public int getRojo() {
		return rojo;
	}
	public void setRojo(int rojo) {
		this.rojo = rojo;
	}
	public int getVerde() {
		return verde;
	}
	public void setVerde(int verde) {
		this.verde = verde;
	}
	public int getAzul() {
		return azul;
	}
	public void setAzul(int azul) {
		this.azul = azul;
	}
	
}
