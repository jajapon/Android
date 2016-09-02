package com.android.listviewbd;

import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class InicioActivity extends AppCompatActivity {
    ListView lista;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio);

        lista = (ListView)findViewById(R.id.listausu);
        String[] users = new String[] {"a","b"};
        ArrayAdapter<String> adaptadorUsu = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, users);

        lista.setAdapter(adaptadorUsu);
        new TareaListadoUsu().execute();
    }
    private class TareaListadoUsu extends AsyncTask<Void,Void,JSONArray>{

        @Override
        protected JSONArray doInBackground(Void... params) {
            String urlConsulta = "http://10.0.2.2:8080/WebServices/listar_usuarios.php";
            JSONArray resultado = Util.getArrayResultado(urlConsulta);
            return resultado;
        }

        @Override
        protected void onPostExecute(JSONArray resultado) {
            super.onPostExecute(resultado);
            if(resultado == null){
                Toast.makeText(getApplicationContext(), "Error", Toast.LENGTH_SHORT).show();
            }else{
                String[] users = new String[resultado.length()];
                for(int i=0; i<resultado.length();i++){
                    try {
                        JSONObject usu = resultado.getJSONObject(i);
                        users[i] = usu.getString("USERNAME");
                        // users[i] = usu.getString("USERPASS");
                        // users[i] = usu.getString("EMAIL");

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                ArrayAdapter<String> adaptadorUsu = new ArrayAdapter<String>(InicioActivity.this, android.R.layout.simple_list_item_1, users);
                lista.setAdapter(adaptadorUsu);
            }
        }
    }
}
