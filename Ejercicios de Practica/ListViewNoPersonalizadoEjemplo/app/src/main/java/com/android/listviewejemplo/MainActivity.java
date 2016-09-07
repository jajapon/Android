package com.android.listviewejemplo;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity implements AdapterView.OnItemClickListener {

    String[] personas;
    ListView lista;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //Inicializamos nuestro listView
        lista = (ListView) findViewById(R.id.listaPersonas);
        //Creamos una lista de prueba para mostrarla
        personas = new String[] {"Pepe","Miguel","María","Ana","Paco","Japón","Antonio"};
        //Creamos un adaptador
        ArrayAdapter<String> adaptador = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, personas);
        //Añadimos el adaptador a nuestro listView para que se muestre
        lista.setAdapter(adaptador);

        //Para tener eventos implementamos el metodo setOnClickListener
        lista.setOnItemClickListener(this);
    }

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Toast.makeText(MainActivity.this, personas[position], Toast.LENGTH_SHORT).show();
    }
}
