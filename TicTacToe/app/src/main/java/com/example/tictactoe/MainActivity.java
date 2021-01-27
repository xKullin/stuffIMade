package com.example.tictactoe;
import android.content.Context;
import android.content.DialogInterface;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.app.AlertDialog;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import java.util.Observable;
import java.util.Observer;

public class MainActivity extends AppCompatActivity implements Observer {
    private Button[][] buttons = new Button[3][3];
    private String name1;
    private String name2;
    public Context context;
    private Model m  = new Model();
    private Controller c = new Controller(m);
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        context = getApplicationContext();
        setContentView(R.layout.activity_main);
        m.addObserver(this);
        createBoard();
    }
    public void createBoard(){
        for (int i = 0; i < 3; i++){
            for(int j = 0; j < 3; j++){
                String buttonId = "button_" + i + j;
                int resId = getResources().getIdentifier(buttonId, "id", getPackageName());
                buttons[i][j] = findViewById(resId);
                buttons[i][j].setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        c.makeMove(view, buttons);
                    }
                });
            }
        }
        Button buttonReset = findViewById(R.id.button_reset);
        buttonReset.setOnClickListener(new View.OnClickListener(){
            public void onClick(View view) {
                restartGame();
            }
        });
        enterNameP1();
    }
    public void restartGame(){
        for (int i = 0; i < 3; i++) { //Sätter alla knappar i spelet till ""
            for (int j = 0; j < 3; j++) {
                buttons[i][j].setEnabled(true);
                buttons[i][j].setText("");
            }
        }
        c.restart();
    }
    public void enterNameP1(){
        LayoutInflater layoutInflater = LayoutInflater.from(MainActivity.this);
        View promptView = layoutInflater.inflate(R.layout.popup_window, null);
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(MainActivity.this);
        alertDialogBuilder.setView(promptView);
        final EditText editText = (EditText) promptView.findViewById(R.id.edittext);

        alertDialogBuilder.setCancelable(false)
                .setPositiveButton("Enter", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        name1 = editText.getText().toString();
                        name1 = name1.trim();
                        enterNameP2();
                    }
                });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }
    public void enterNameP2(){
        LayoutInflater layoutInflater = LayoutInflater.from(MainActivity.this);
        View promptView = layoutInflater.inflate(R.layout.popup_window, null);
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(MainActivity.this);
        alertDialogBuilder.setView(promptView);
        final EditText editText = (EditText) promptView.findViewById(R.id.edittext);
        alertDialogBuilder.setCancelable(false)
                .setPositiveButton("Enter", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        name2 = editText.getText().toString();
                        name2 = name2.trim();
                        c.setNames(name1, name2);
                    }
                });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }
    public void declareWinner(){
        String winName = c.getWinnerName();
        AlertDialog alertDialog = new AlertDialog.Builder(MainActivity.this).create();
        alertDialog.setTitle("Winner");
        alertDialog.setMessage(winName + " wins the game!");
        alertDialog.setButton(AlertDialog.BUTTON_NEUTRAL, "Play again",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                });
        alertDialog.show();
    }
    public void declareDraw(){
        String winName = c.getWinnerName();
        AlertDialog alertDialog = new AlertDialog.Builder(MainActivity.this).create();
        alertDialog.setTitle("Draw");
        alertDialog.setMessage("The game ends in a draw!");
        alertDialog.setButton(AlertDialog.BUTTON_NEUTRAL, "Play again",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                });
        alertDialog.show();
    }
    @Override
    public void update(Observable observable, Object o) {
        if(m.winner){
            declareWinner();
            restartGame();
        }
        if(m.gameIsDraw){
            declareDraw();
            restartGame();
        }

    }
}