package com.android.practicaeventos;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class BienvenidoActivity extends AppCompatActivity {
    TextView u,p,e;
    Button logout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_bienvenido);

        Bundle datosExtras = getIntent().getExtras();
        String usu = datosExtras.getString("user");
        new TareaDatosUser().execute(usu);

        logout = (Button)findViewById(R.id.remove);
        logout.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                //Creamos nuestro objeto SharedPreference
                SharedPreferences prefs =  getSharedPreferences("MisPreferencias",getApplicationContext().MODE_PRIVATE);

                //Abrimos el editor para editar en el archivo donde guardaremos datos
                SharedPreferences.Editor editor = prefs.edit();

                //borramos el contenido
                editor.clear();

                //comiteamos o guardamos cambios
                editor.commit();

                Intent i = new Intent(BienvenidoActivity.this, MainActivity.class);
                startActivity(i);
            }
        });
    }

    public class TareaDatosUser extends AsyncTask<String, Void, JSONArray>{

        @Override
        protected JSONArray doInBackground(String... params) {
            String username = params[0];
            String uriServicio = "http://10.0.2.2:8080/WebServices/recuperar_datos_user.php?username="+username;
            JSONArray resultado = Util.getArrayResultado(uriServicio);
            return resultado;
        }

        @Override
        protected void onPostExecute(JSONArray resultado) {
            super.onPostExecute(resultado);
            if(resultado == null){
                Toast.makeText(BienvenidoActivity.this, "Error de conexion", Toast.LENGTH_SHORT).show();
            }else{
                u = (TextView) findViewById(R.id.dato1);
                p = (TextView) findViewById(R.id.dato2);
                e = (TextView) findViewById(R.id.dato3);

                for(int i=0; i<resultado.length();i++){
                    try {
                        JSONObject usuario = resultado.getJSONObject(i);
                        u.setText(usuario.getString("USERNAME"));
                        p.setText(usuario.getString("USERPASS"));
                        e.setText(usuario.getString("EMAIL"));
                    } catch (JSONException e1) {
                        e1.printStackTrace();
                    }
                }
            }
        }
    }
}
