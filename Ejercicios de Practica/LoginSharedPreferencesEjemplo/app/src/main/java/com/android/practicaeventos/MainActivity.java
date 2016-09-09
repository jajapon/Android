package com.android.practicaeventos;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

    EditText usu, pass;
    Button login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //Recuperamos el sharedPreferences
        SharedPreferences prefs = getSharedPreferences("MisPreferencias",getApplicationContext().MODE_PRIVATE);

        //Una vez recuperado usamos el metodo getString pasandole la clave que pusimos y un valor por defecto en caso de no devolver nada para que no devuelva nulo
        String logeado = prefs.getString("logeado", "no");
        String usuario = prefs.getString("usuariologeado", "ejemplo");

        if(logeado.equals("si")){
            //Creamos un Intent
            Intent i = new Intent(MainActivity.this,BienvenidoActivity.class);
            //Para pasar parametros a la otra actividad
            i.putExtra("user",usuario);
            //Iniciamos la nueva Actividad
            startActivity(i);
        }else{
            usu = (EditText) findViewById(R.id.usu);
            pass = (EditText) findViewById(R.id.pas);
            login = (Button) findViewById(R.id.login);

            login.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    String username = usu.getText().toString();
                    String password = pass.getText().toString();
                    new TareaLogin().execute(username,password);
                }
            });
        }
    }

    public class TareaLogin extends AsyncTask <String,Void,String>{

        @Override
        protected String doInBackground(String... params) {
            String user = params[0];
            String pass = params[1];
            String urlConsulta = "http://10.0.2.2:8080/WebServices/login.php?username="+user+"&userpass="+pass;
            String resultado = Util.getResultadoUrl(urlConsulta);
            return resultado;
        }

        @Override
        protected void onPostExecute(String resultado) {
            super.onPostExecute(resultado);
            if(resultado==null){
                Toast.makeText(MainActivity.this, "Error de conexión", Toast.LENGTH_SHORT).show();
            }else{
                if(resultado.equals("Login incorrecto")){
                    Toast.makeText(MainActivity.this, "Usuario o contraseña incorrecto", Toast.LENGTH_SHORT).show();
                }else{
                    //Creamos un Intent
                    Intent i = new Intent(MainActivity.this,BienvenidoActivity.class);
                    //Para pasar parametros a la otra actividad
                    i.putExtra("user",usu.getText().toString());
                    //Iniciamos la nueva Actividad
                    startActivity(i);
                }
            }
            //Creamos nuestro objeto SharedPreference
            SharedPreferences prefs =  getSharedPreferences("MisPreferencias",getApplicationContext().MODE_PRIVATE);

            //Abrimos el editor para editar en el archivo donde guardaremos datos
            SharedPreferences.Editor editor = prefs.edit();

            //Añadimos datos (clave / valor) para recuperarlos al iniciar la app posteriormente
            editor.putString("logeado", "si");
            editor.putString("usuariologeado", usu.getText().toString());
            //editor.putBoolean("claveBooleana", false);
            //editor.putFloat("claveFloat",(float) 2.4);
            //editor.putInt("claveEntera", 5);

            //Guardamos los cambios
            editor.commit();

        }
    }
}
