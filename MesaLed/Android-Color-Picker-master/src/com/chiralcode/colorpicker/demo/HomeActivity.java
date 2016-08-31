package com.chiralcode.colorpicker.demo;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.UUID;

import com.chiralcode.colorpicker.Bloque;
import com.chiralcode.colorpicker.R;
import java.util.UUID;
import android.R.drawable;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.res.Resources;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.graphics.drawable.Drawable;
import android.graphics.drawable.PaintDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.Toast;
import at.abraxas.amarino.Amarino;


@SuppressLint("NewApi") public class HomeActivity extends Activity implements OnClickListener {

	private static final int REQUEST_ENABLE_BT = 1;
	protected static final String TAG = null;
	static int contador=0;
	Button[] buttons;
	Button borrar;
	Button enviar;
	String [] a = new String[3];
	Bloque [] b;
	View current;
	BluetoothAdapter mBluetoothAdapter = null;
	BroadcastReceiver mReceiver;
	BluetoothDevice mDevice;
	BluetoothSocket mBSocket;
	private OutputStream mmOutputStream;
	private InputStream mmInputStream;
	 String uid;
	protected int rojo;
	protected int verde;
	protected int azul;
	private static final String DEVICE_ADDRESS = "98:D3:31:20:26:13";

     //String a enviar
     private String dataToSend;
     //Variables para el manejo del bluetooth Adaptador y Socket
     private BluetoothSocket btSocket = null;
     //Streams de lectura I/O
     private OutputStream outStream = null;
     private InputStream inStream = null;
	private String uuid;
	protected String envio;
     //MAC Address del dispositivo Bluetooth
     private static String address = "98:D3:31:20:26:13";
     //Id Unico de comunicacion
     private static UUID MY_UUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.home_layout);

		TelephonyManager tManager = (TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
		uuid = tManager.getDeviceId();
		
		initializeButtons(100);
		borrar = (Button) findViewById(R.id.borrar);
		borrar.setClickable(true);
		borrar.setOnClickListener(new OnClickListener() {
        	@Override
            public void onClick(View v) {
        	    Resources res = getResources();
        		for (int i = 0; i < buttons.length; i++) {
        	        String b = "b" + (i+1);
        	        buttons[i] = (Button) findViewById(res.getIdentifier(b, "id", getPackageName()));
        	        buttons[i].setBackgroundDrawable(getResources().getDrawable(
        					R.drawable.button_border));
        	        buttons[i].setClickable(true);
        	        buttons[i].setOnClickListener(new OnClickListener() {
        	        	@Override
        	            public void onClick(View v) {
        	        		 current = v;
        	        		 Intent i;
        	    			 i = new Intent("app.PROYECTO.COLOR_PICKER");
        	    			 startActivityForResult(i, 2);	    			 
        	            }
        	        });
        	    }    			 
            }
        	
        });
		enviar = (Button) findViewById(R.id.enviar);
		enviar.setClickable(true);
		enviar.setOnClickListener(new OnClickListener() {
        	@Override
            public void onClick(View v) {
        	    Resources res = getResources();
        	    Button boton = buttons[0];
        	    ColorDrawable  drawable =  (ColorDrawable) boton.getBackground();
        	    int color = drawable.getColor();
        		
        		rojo = Color.red(color);
        		verde = Color.green(color);
        		azul = Color.blue(color);
        		
        		String rs = convertToString(rojo);
        		String gs = convertToString(verde);
        		String bs = convertToString(azul);
        

        		envio ="000"+rs+""+gs+""+bs+"\r\n";
        		new JaponEnvia().execute(envio);         		
        		Toast.makeText(HomeActivity.this, envio, Toast.LENGTH_SHORT).show();
            }
        	
        });
		
		CheckBt();

		
	}
	
	//Metodo de verificacion del sensor Bluetooth
    private void CheckBt() {
        //asignamos el sensor bluetooth con el que vamos a trabajar
        mBluetoothAdapter = BluetoothAdapter.getDefaultAdapter();

        //Verificamos que este habilitado
        if (!mBluetoothAdapter.enable()) {
            Toast.makeText(this, "Bluetooth Desactivado",
                Toast.LENGTH_SHORT).show();
        }
        //verificamos que no sea nulo el sensor
        if (mBluetoothAdapter == null) {
            Toast.makeText(this,
                "Bluetooth No Existe o esta Ocupado", Toast.LENGTH_SHORT)
                .show();
        }
    }
    
    public void Connect() {
        //Iniciamos la conexion con el arduino
        BluetoothDevice device = mBluetoothAdapter.getRemoteDevice(address);
        Log.i("Conectando...","Conexion en curso" + device);

        //Indicamos al adaptador que ya no sea visible
        mBluetoothAdapter.cancelDiscovery();
        try {
            //Inicamos el socket de comunicacion con el arduino
            btSocket = device.createInsecureRfcommSocketToServiceRecord(MY_UUID);
            //Conectamos el socket
            btSocket.connect();
            Log.i("Conectando...","Conexion Correcta");
        } catch (Exception e) {
            //en caso de generarnos error cerramos el socket
        	Log.i("Conectando...",e.getMessage());
            
        }
        //Una vez conectados al bluetooth mandamos llamar el metodo que generara el hilo
        //que recibira los datos del arduino
        //NOTA envio la letra e ya que el sketch esta configurado para funcionar cuando
        //recibe esta letra.
        
    }
    
    //Metodo de envio de datos la bluetooth
    private void writeData(String data) {
        //Extraemos el stream de salida
        try {
            outStream = btSocket.getOutputStream();
        } catch (Exception e) {
            Log.i("enviando1..", "Error al enviar"+e.getMessage());
        }

        //creamos el string que enviaremos
        String message = data;

        //lo convertimos en bytes
        byte[] msgBuffer = message.getBytes();

        try {
            //Escribimos en el buffer el arreglo que acabamos de generar
            outStream.write(msgBuffer, 0, msgBuffer.length);
        } catch (Exception e) {
        	Log.i("enviando2..", "Error al enviar"+e.getMessage());
        }
        
        try {
			btSocket.close();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    }
	
	// Call Back method  to get the Message form other Activity  
    @Override  
       protected void onActivityResult(int requestCode, int resultCode, Intent data)  
       {  
                 super.onActivityResult(requestCode, resultCode, data);  
                  // check if the request code is same as what is passed  here it is 2  
                   if(requestCode==2){  
                         a = (data.getStringExtra("RGB")).split("-"); 
                         current.setBackgroundColor(Color.rgb(Integer.parseInt(a[0]),
                         Integer.parseInt(a[1]), Integer.parseInt(a[2])));
                            
                   }  
     }  
	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub 
		Intent i;
		 i = new Intent("app.PROYECTO.COLOR_PICKER");
		 current = v;
		 startActivityForResult(i, 2);
		 //v.setBackgroundColor(Color.rgb(Integer.parseInt(a[0]),Integer.parseInt(a[1]),Integer.parseInt(a[2])));		
	}	
	public void initializeButtons(int x) {
	    Resources res = getResources();
	    buttons = new Button[x];
	    b = new Bloque[x];
	    for (int i = 0; i < x; i++) {
	        String b = "b" + (i+1);
	        buttons[i] = (Button) findViewById(res.getIdentifier(b, "id", getPackageName()));
	        buttons[i].setClickable(true);
	        buttons[i].setBackgroundDrawable(getResources().getDrawable(
					R.drawable.button_border));
	        buttons[i].setOnClickListener(new OnClickListener() {
	        	@Override
	            public void onClick(View v) {
	        		 current = v;
	        		 Intent i;
	    			 i = new Intent("app.PROYECTO.COLOR_PICKER");
	    			 startActivityForResult(i, 2);	    			 
	            }
	        });
	    }
	}
	public String convertToString(int numC){
		String cadena="";
		if(numC < 10){
			cadena = "00"+numC;
		}
		if(numC >=10 && numC<=99 ){
			cadena = "0"+numC;
		}
		if(numC >= 100){
			cadena=""+numC;
		}
		return cadena;
	}

	public class JaponEnvia extends AsyncTask<String,Void,Void> {

		@Override
		protected Void doInBackground(String... params) {
			// TODO Auto-generated method stub
			Connect();
    	
    		writeData(envio);
			return null;
		}
	 }
}


