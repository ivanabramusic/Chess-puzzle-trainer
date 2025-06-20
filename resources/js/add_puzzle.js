import '@chrisoakman/chessboardjs/dist/chessboard-1.0.0.min.css';
import '@chrisoakman/chessboardjs/dist/chessboard-1.0.0.min.js';
import { Chess } from 'chess.js';


document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('form');
    const fenInput = document.getElementById('fen');

    form.addEventListener('submit', () => {
        if (fenInput && board) {
            fenInput.value = board.fen();
        }
    });


    function createBoard(options = {}) {
        const defaultConfig = {
            pieceTheme: '/images/chesspieces/wikipedia/{piece}.png',
            draggable: true,
        };
        const finalConfig = { ...defaultConfig, ...options };
        return window.Chessboard('board', finalConfig);
    }

    function showMessage(message, type = 'info') {
        let messageBox = document.getElementById('messageBox');
        if (!messageBox) {
            messageBox = document.createElement('div');
            messageBox.className = 'puzzle-message-box';
            document.body.appendChild(messageBox);
        }

        messageBox.textContent = message;
        messageBox.classList.remove('info', 'success', 'error');
        messageBox.classList.add(type);
        messageBox.style.opacity = '1';

        setTimeout(() => {
            messageBox.style.opacity = '0';
        }, 3000);
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
        const activeColor = playsFirstSelect ? (playsFirstSelect.value === 'white' ? 'w' : 'b') : 'w';
        const castlingRights = castlingRightsInput ? castlingRightsInput.value : '-';
        const enPassantTarget = '-';
        const halfmoveClock = String(Number(1));  
        const fullmoveNumber = String(Number(1));

        return `${piecePlacementFen} ${activeColor} ${castlingRights} ${enPassantTarget} ${halfmoveClock} ${fullmoveNumber}`;
    }

   


    function onDragStart (source, piece, position, orientation) {
        if(chess)
        if (chess.isGameOver()) return false

        if ((chess.turn() === 'w' && piece.search(/^b/) !== -1) ||
            (chess.turn() === 'b' && piece.search(/^w/) !== -1)) {
            return false
        }
            
        return true;
    }

    function onSnapEnd () {
        board.position(chess.fen())
    }

    function onDrop (source, target)
    {
        if (!isRecording) {
            return 'snapback';
        }

        if (!chess) {
            showMessage('Greška: Chess.js engine nije inicijaliziran. Kliknite "Start Recording"!', 'error');
            return 'snapback';
        }

        const move = {
        from: source,
        to: target,
        promotion: 'q'
        };

        try {
            const result = chess.move(move);
            console.log('Potez pokušaj:', move, 'Na potezu:', chess.turn());


            if (result === null) {
                return 'snapback';
            }

            if (isRecording) {
                moves.push(result.san);
            }


        } catch (e) {
            console.error('Nevaljan potez!', move, e);
            return 'snapback'; 
        }
    }


    let recordingMode = false;
    let isRecording = false;
    let moves = [];
    let preRecordingPosition = null; 
    let chess = null;
    let board;

    const castlingRightsInput = document.getElementById('castlingRights');
    const playsFirstSelect = document.querySelector('select[name="plays_first"]');
    var orientation = playsFirstSelect?.value === 'black' ? 'black' : 'white';

    board = createBoard({
        position: 'start', 
        sparePieces: true,
        dropOffBoard: 'trash', 
        orientation: playsFirstSelect?.value === 'black' ? 'black' : 'white',
        onDrop: (source, target, piece, newPos, oldPos, orientation) => {
        }
    });


    const toggleRecording = document.getElementById('toggleRecordingMode');
    const recordControls = document.getElementById('recordControls');

    toggleRecording.addEventListener('change', (e) => {
        recordingMode = e.target.checked;

        const boardContainer = document.getElementById('board');
        const boardRect = boardContainer.getBoundingClientRect();
        const boardWidth = boardRect.width + 'px';
        const boardHeight = boardRect.height + 'px';
        const fenBeforeDestroyPartial = board && typeof board.fen === 'function' ? board.fen() : 'start';
        var orientation = playsFirstSelect?.value === 'black' ? 'black' : 'white';

        boardContainer.style.width = boardWidth;
        boardContainer.style.height = boardHeight;
        
        if (board) {
            board.destroy();
        }
        boardContainer.innerHTML = '';

        if (!recordingMode && chess) {
            chess = null;
            isRecording = false;
            moves = [];
        }

        if(recordingMode)
        {
            preRecordingPosition = fenBeforeDestroyPartial;

            if (recordControls) {
                recordControls.style.display = 'block';
            }

            board = createBoard({
                position: preRecordingPosition,
                draggable: true,
                orientation: playsFirstSelect?.value === 'black' ? 'black' : 'white',
                onDragStart: onDragStart,
                onSnapEnd: onSnapEnd,
                onDrop: onDrop
            })
        }
        else {
            if (recordControls) {
                recordControls.style.display = 'none';
            }
            isRecording = false;
            moves = [];
            board = createBoard({
                position: fenBeforeDestroyPartial,
                sparePieces: true,
                dropOffBoard: 'trash',
                orientation: playsFirstSelect?.value === 'black' ? 'black' : 'white',
                onDrop: (source, target, piece) => {
                    return true; 
                    }
                });

        }

        boardContainer.style.width = ''; 
        boardContainer.style.height = '';
    });


    document.getElementById('startRecording').addEventListener('click', () => {
        if (!recordingMode) {
            showMessage('Prvo omogućite mod snimanja!', 'error');
                return;
            }
            if (isRecording) {
                showMessage('Snimanje je već aktivno!', 'info');
                return;
            }

            chess = new Chess();
            const currentBoardFenPartial = board.fen();
            const fullFenForChessJS = buildFullFen(currentBoardFenPartial);


            if (isValidFen(fullFenForChessJS)) {
                chess.load(fullFenForChessJS);
            } else {
                chess.reset();
                showMessage('Nevažeći FEN na ploči, engine resetiran na početnu poziciju.', 'info');
            }

            console.log("FEN:", fullFenForChessJS);
            console.log("Na potezu:", chess.turn());

            isRecording = true;
            moves = [];
            showMessage('Snimanje započeto! Sada možete praviti poteze.', 'success');
    });

    document.getElementById('resetToPreRecording').addEventListener('click', () => {
        if (!preRecordingPosition) {
            showMessage('No recorded position to reset to.', 'error');
            return;
        }
        board.position(preRecordingPosition, false);
        chess.reset();
        moves = [];
        isRecording = false;
        showMessage('Board reset.', 'info');
    });

    document.getElementById('stopRecording').addEventListener('click', () => {
        if (!recordingMode) {
            showMessage('Recording mode is not enabled!', 'error');
            return;
        }
        if (!isRecording) {
            showMessage('Recording is not started yet!', 'error');
            return;
        }

        isRecording = false;

        document.querySelector('input[name="solution"]').value = moves.join(' ');

        showMessage('Recording stopped. Moves saved in solution field.', 'success');
    });


    document.getElementById('clearBoard').addEventListener('click', () => {
        board.position({}, false);
        chess.reset();
        document.getElementById('fen').value = '';
        showMessage('Board cleared!', 'info');
    });

    document.getElementById('resetBoard').addEventListener('click', () => {
        board.start();
        chess.reset();
        document.getElementById('fen').value = '';
        showMessage('Board reset!', 'info');
    });

    document.querySelector('form').addEventListener('submit', (e) => {
        if (recordingMode && moves.length > 0) {
            document.getElementById('fen').value = board.fen();
        } else {
            document.getElementById('fen').value = board.fen();
        }
    });



    if (playsFirstSelect) {
        playsFirstSelect.addEventListener('change', (e) => {
            orientation = e.target.value === 'black' ? 'black' : 'white';
            board.orientation(orientation);
        });
    }


});
