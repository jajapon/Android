package com.insertendb.android.insertendb;

import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

public class InicioActivity extends AppCompatActivity {
    private EditText user, pass, email;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio);

        user = (EditText) findViewById(R.id.username);
        pass = (EditText) findViewById(R.id.userpass);
        email = (EditText) findViewById(R.id.email);
    }

    public void doInsert(View view) {
        String u = user.getText().toString();
        String p = pass.getText().toString();
        String e = email.getText().toString();

        new TareaInsert().execute(u,p,e);
    }

    private class TareaInsert extends AsyncTask <String,Void,String>{
        @Override
        protected String doInBackground(String... params) {
            String usu = params[0];
            String con = params[1];
            String ema = params[2];

            String urlConsulta = "http://10.0.2.2:8080/WebServices/alta_usuario.php?username="+usu+"&userpass="+con+"&email="+ema;
            String respuesta = Util.getResultadoUrl(urlConsulta);
            return respuesta;
        }

        @Override
        protected void onPostExecute(String resultado) {
            super.onPostExecute(resultado);
            if(resultado == null){
                Toast.makeText(getApplicationContext(), "Usuario no insertado", Toast.LENGTH_SHORT).show();
            }else{
                Toast.makeText(getApplicationContext(), "Usuario insertado", Toast.LENGTH_SHORT).show();
            }
        }
    }
}
