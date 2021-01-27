package com.example.tictactoe;

import android.content.Context;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import java.util.Observable;
import java.util.Observer;


public class Model extends Observable{
    public boolean winner;
    public String currLetter;
    public int roundCount;
    public boolean gameIsDraw;
    public String winnerName;
    public String player1;
    public String player2;
    public String board [][];
    public Model(){
        winner = false;
        gameIsDraw = false;
        currLetter = "X";
        board = new String[3][3];
    }
    public void addToField(Button buttons[][]){
        roundCount++;
        for (int i = 0; i < 3; i++) {
            for (int j = 0; j < 3; j++) {
                board[i][j] = buttons[i][j].getText().toString(); //
            }
        }
    }
    public void resetGame(){
        roundCount = 0;
        winner = false;
        gameIsDraw = false;
        winnerName = "";
        currLetter = "X";
        for(int i = 0; i < 3; i++) {
            for (int j = 0; j < 3; j++) {
                board[i][j] = "";
            }
        }
    }
    public void gameIsWon(){
        winner = true;
        if(currLetter == "X"){
            winnerName = player1;
        }else{
            winnerName = player2;
        }
        setChanged();
        notifyObservers();
    }
    public void checkForWinner() {
        //Vinstlogik
        if (roundCount != 9) {
            for (int i = 0; i < 3; i++) {
                if (board[i][0].equals(board[i][1])
                        && board[i][0].equals(board[i][2])
                        && !board[i][0].equals("")) {
                    gameIsWon();
                }
            }
            for (int i = 0; i < 3; i++) {
                if (board[0][i].equals(board[1][i])
                        && board[0][i].equals(board[2][i])
                        && !board[0][i].equals("")) {
                    gameIsWon();
                }
            }
            if (board[0][0].equals(board[1][1])
                    && board[0][0].equals(board[2][2])
                    && !board[0][0].equals("")) {
                gameIsWon();
            }
            if (board[0][2].equals(board[1][1])
                    && board[0][2].equals(board[2][0])
                    && !board[0][2].equals("")) {
                gameIsWon();
            }
        }else{
            gameIsDraw = true;
            setChanged();
            notifyObservers();
        }
    }
}
