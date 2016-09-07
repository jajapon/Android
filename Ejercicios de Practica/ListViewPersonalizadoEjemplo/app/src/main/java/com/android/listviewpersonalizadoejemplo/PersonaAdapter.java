package com.android.listviewpersonalizadoejemplo;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class PersonaAdapter extends ArrayAdapter<PersonaItem>{
    Context contexto;
    ArrayList<PersonaItem> personas;
    int layoutPersonas;

    public PersonaAdapter(Context context, int resource, ArrayList<PersonaItem> objects) {
        super(context, resource, objects);
        this.contexto = context;
        this.personas = objects;
        this.layoutPersonas = resource;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        //return super.getView(position, convertView, parent);

        //creamos un inflater
        LayoutInflater inflater = (LayoutInflater) contexto.getSystemService(contexto.LAYOUT_INFLATER_SERVICE);

        //Creamos una vista
        View layoutItemPersona = inflater.inflate(layoutPersonas, parent, false);

        //Recuperamos la persona seleccionada
        PersonaItem personaSelec = personas.get(position);

        //Rescatando elementos del layout
        ImageView icono = (ImageView) layoutItemPersona.findViewById(R.id.icono);
        TextView nomYEdad = (TextView) layoutItemPersona.findViewById(R.id.nombreedad);
        TextView email = (TextView) layoutItemPersona.findViewById(R.id.email);

        //Insertando datos en los campos
        nomYEdad.setText(personaSelec.getNombre()+", "+personaSelec.getEdad()+" años");
        email.setText(personaSelec.getEmail());
        if(personaSelec.getSexo().equals("H")){
            icono.setImageResource(R.drawable.ic_chico);
        }else{
            icono.setImageResource(R.drawable.ic_chica);
        }

        //devolvemos la vista
        return layoutItemPersona;
    }
}