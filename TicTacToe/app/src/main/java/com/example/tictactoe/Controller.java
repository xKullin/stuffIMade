package com.example.tictactoe;

import android.content.Context;

import android.util.Log;
import android.widget.Button;
import android.widget.Toast;
import android.view.View;

public class Controller  {
    private Model m;
    public Controller(Model m) {
        this.m = m;
    }

    public void makeMove(View v, Button[][] buttons) {
        ((Button) v).setText(m.currLetter);
        ((Button) v).setEnabled(false);
        m.addToField(buttons);
        m.checkForWinner();
        if(m.currLetter.equals("X")){
            m.currLetter = "O";
        }else{
            m.currLetter = "X";
        }
    }
    public void setNames(String name1, String name2){
        m.player1 = name1;
        m.player2 = name2;
    }
    public String getWinnerName(){
        return m.winnerName;
    }
    public void restart() {
        m.resetGame();
    }
}