package com.android.listviewpersonalizadoejemplo;

import android.app.ListActivity;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.util.ArrayList;

public class MainActivity extends ListActivity {
    ArrayList<PersonaItem> listaPersonas;
    ListView milista;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Creamos una lista de tipo PersonaItem
        listaPersonas = new ArrayList<PersonaItem>();
        //Añadimos elementos a nuestra lista
        listaPersonas.add(new PersonaItem("Juan Antonio Japon de la Torre",25,"juan.antonio.japon@gmail.com","H"));
        listaPersonas.add(new PersonaItem("Antonio Jimenez Verdejo",25,"ajv.jimenez@gmail.com","H"));
        listaPersonas.add(new PersonaItem("Paco Jimenez Verdejo",27,"pacoJimVer@gmail.com","H"));
        listaPersonas.add(new PersonaItem("Ana Maria de las Mercedes",27,"anamaridlmercedes@gmail.com","M"));
        listaPersonas.add(new PersonaItem("Pablo Artista",27,"pabloartista@gmail.com","H"));
        listaPersonas.add(new PersonaItem("Manuel Moreno",27,"manumz@gmail.com","H"));
        listaPersonas.add(new PersonaItem("David Romero Ballesta",26,"david.romero.ballesta@gmail.com","H"));

        //Creamos un adaptador del tipo que hemos creado anteriormente
        PersonaAdapter adaptador = new PersonaAdapter(this, R.layout.list_item_personas, listaPersonas);

        //Añadimos el adaptador a la vista
        setListAdapter(adaptador);
    }
}
