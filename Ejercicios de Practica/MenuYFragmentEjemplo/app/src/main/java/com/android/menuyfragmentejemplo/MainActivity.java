package com.android.menuyfragmentejemplo;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.FrameLayout;

public class MainActivity extends AppCompatActivity {
    FrameLayout contenedorLayouts;
    boolean changeOption = true;
    PrimerFragment primerF;
    SegundoFragment segundoF;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        contenedorLayouts = (FrameLayout) findViewById(R.id.contenedorLayouts);
        primerF = new PrimerFragment();

        getSupportFragmentManager().beginTransaction().add(R.id.contenedorLayouts,primerF).commit();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_principal,menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch(item.getItemId()){
            case R.id.opcion1:
                //Evento a realizar
                if(changeOption==false){
                    getSupportFragmentManager().beginTransaction().replace(R.id.contenedorLayouts,new SegundoFragment()).commit();
                    changeOption = true;
                }else{
                    getSupportFragmentManager().beginTransaction().replace(R.id.contenedorLayouts,new PrimerFragment()).commit();
                    changeOption = false;
                }
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}
