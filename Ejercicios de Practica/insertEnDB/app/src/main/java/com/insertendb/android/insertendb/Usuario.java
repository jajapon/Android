package com.insertendb.android.insertendb;

/**
 * Created by Juan on 02/09/2016.
 */
public class Usuario {
    private String username;
    private String userpass;
    private String email;

    public Usuario(){
    }
    public Usuario(String username, String userpass, String email){
        this.username = username;
        this.userpass = userpass;
        this.email = email;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getUserpass() {
        return userpass;
    }

    public void setUserpass(String userpass) {
        this.userpass = userpass;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }
}
