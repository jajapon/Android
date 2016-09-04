package com.android.fragmentsejemplo;


import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


/**
 * A simple {@link Fragment} subclass.
 */
public class LoginFragment extends Fragment {

    public LoginFragment() {
        // Required empty public constructor
    }

    EditText cuser, cpass;
    Button login;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        //En fragmentos recuperamos la vista en un objeto View
        View v = inflater.inflate(R.layout.fragment_login, container, false);
        // Para recuperar los campos en un framento debemos utilizar el objeto View y llamar a findViewById
        cuser = (EditText) v.findViewById(R.id.cuser);
        cpass = (EditText) v.findViewById(R.id.cpass);
        login = (Button) v.findViewById(R.id.loginb);

        //evento del boton de login
        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(v.getContext(),"Prueba login", Toast.LENGTH_SHORT).show();
            }
        });
        //devolvemos la vista del fragmento que se cargara
        return v;
    }

}
