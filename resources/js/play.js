import '@chrisoakman/chessboardjs/dist/chessboard-1.0.0.min.css';
import '@chrisoakman/chessboardjs/dist/chessboard-1.0.0.min.js';
import { Chess, validateFen } from 'chess.js';

document.addEventListener('DOMContentLoaded', function () {
    const boardElement = document.getElementById('board');
    const messageArea = document.getElementById('messageArea');
    const backButton = document.getElementById('backButton');
    const data = document.getElementById('puzzle-data');

    const initialFenRaw = data.dataset.fen;
    const solutionMoves = data.dataset.solution?.split(' ') || [];
    const playsFirstColor = data.dataset.playsFirst || 'white';

    let game;
    let boardInstance;
    let currentMoveIndex = 0;

    function showMessage(text, type = 'info') {
        if (!messageArea) return;
        messageArea.textContent = text;
        messageArea.className = 'message-area';

        if (type === 'success') messageArea.classList.add('message-success');
        else if (type === 'error') messageArea.classList.add('message-error');

        if (text.includes('Zagonetka riješena!')) {
            messageArea.classList.add('puzzle-solved-message');
        }
    }

    function isValidFen(fen) {
        try {
            const testChess = new Chess(fen);
            return true;
        } catch (e) {
            console.error("Error validating FEN:", e);
            return false;
        }
    }

    function buildFullFen(piecePlacementFen) {
        const activeColor = playsFirstColor === 'white' ? 'w' : 'b';
        const defaultPlacement = '8/8/8/8/8/8/8/8';
        const placement = piecePlacementFen?.trim() || defaultPlacement;
        return `${placement} ${activeColor} - - 0 1`;
    }

    function handlePuzzleSolved() {
        showMessage('Zagonetka riješena! Bravo!', 'success');
        if (backButton) backButton.classList.remove('d-none');
    }

    function makeComputerMove() {
        if (currentMoveIndex >= solutionMoves.length) return handlePuzzleSolved();

        const san = solutionMoves[currentMoveIndex];

        const move = game.move(san);

        console.log(move);

        if (!move) {
            console.error("Neispravan računalni potez:", san);
            showMessage('Greška u zagonetki.', 'error');
            return handlePuzzleSolved();
        }

        boardInstance.position(game.fen());
        currentMoveIndex++;

        if (currentMoveIndex >= solutionMoves.length) return handlePuzzleSolved();

        showMessage(`Tvoj je potez. Na potezu je ${game.turn() === 'w' ? 'bijeli' : 'crni'}.`, 'info');
    }

    function onDragStart(source, piece) {
        if (game.isGameOver()) {
            showMessage('Igra je gotova!', 'info');
            return false;
        }

        const isUserTurn = (playsFirstColor === 'white' && game.turn() === 'w') ||
                           (playsFirstColor === 'black' && game.turn() === 'b');

        return isUserTurn && piece.startsWith(game.turn());
    }

    function onDrop(source, target) {

        let move;

        try {
            move = game.move({ from: source, to: target, promotion: 'q' });
        } catch (error) {
            console.warn('Potez izazvao grešku:', error);
            showMessage('Nevaljan potez!', 'error');
            return 'snapback';
        }

        if (move === null) {
            showMessage('Nevaljan potez!', 'error');
            return 'snapback';
        }

        if (move.san !== solutionMoves[currentMoveIndex]) {
            game.undo();
            showMessage('Potez nije točan.', 'error');
            return 'snapback';
        }

        currentMoveIndex++;
        showMessage('Točan potez!', 'success');

        if (currentMoveIndex >= solutionMoves.length) {
            return handlePuzzleSolved();
        }

        setTimeout(makeComputerMove, 500);
        return true;
    }

    function onSnapEnd() {
        boardInstance.position(game.fen());
    }


    let fenToUse = initialFenRaw;
    const hasOnlyPlacement = fenToUse.trim().split(' ').length === 1;
    const piecePlacement = fenToUse.trim().split(' ')[0];
 
    if (hasOnlyPlacement || !isValidFen(fenToUse)) {
        fenToUse = buildFullFen(piecePlacement);
    }

    if (!isValidFen(fenToUse)) {
        showMessage("Greška: Nevažeći FEN. Učitana početna pozicija.", 'error');
        fenToUse = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';
    }


    try {
        game = new Chess(fenToUse);
    } catch (err) {
        console.error("Neuspješno pokretanje igre:", err);
        game = new Chess();
    }



    boardInstance = window.Chessboard(boardElement, {
        pieceTheme: '/images/chesspieces/wikipedia/{piece}.png',
        position: piecePlacement,
        draggable: true,
        orientation: playsFirstColor,
        onDragStart: onDragStart,
        onDrop: onDrop,
        onSnapEnd: onSnapEnd,
    });

    showMessage(`Na potezu je ${game.turn() === 'w' ? 'bijeli' : 'crni'}.`, 'info');
});
