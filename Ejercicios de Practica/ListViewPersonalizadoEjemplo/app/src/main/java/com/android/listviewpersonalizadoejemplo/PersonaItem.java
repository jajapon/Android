package com.android.listviewpersonalizadoejemplo;

/**
 * Created by Juan on 07/09/2016.
 */
public class PersonaItem {
    private String nombre;
    private int edad;
    private String email;
    private String sexo;

    public PersonaItem() {

    }

    public PersonaItem(String nombre, int edad, String email, String sexo) {
        this.nombre = nombre;
        this.edad = edad;
        this.email = email;
        this.sexo = sexo;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public int getEdad() {
        return edad;
    }

    public void setEdad(int edad) {
        this.edad = edad;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getSexo() {
        return sexo;
    }

    public void setSexo (String sexo) {
        this.sexo = sexo;
    }
}
