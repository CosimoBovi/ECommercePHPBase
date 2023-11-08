# Database

E' giunto il momento di introdurre un elemento fondamentale per molte applicazioni web: il database. I database sono componenti essenziali in cui vengono archiviati dati come utenti, prodotti e informazioni cruciali per il funzionamento dell'applicazione.

In questa sezione, esploreremo l'importanza di un database per la nostra applicazione e inizieremo gradualmente a costruire il nostro. Cominceremo dalla gestione degli utenti, un elemento centrale per la maggior parte delle applicazioni web. Creeremo tabelle, definiremo la struttura dei dati e impareremo a inserire, recuperare e gestire informazioni sugli utenti.

# Modello Logico Utenti

Nel nostro modello logico, ci concentreremo su due tabelle principali:

**1. Tabella "Users":**
   - **UserID:** Questo campo rappresenta un identificatore unico per ciascun utente. Sarà utilizzato per distinguere gli utenti in modo univoco.
   - **Username:** Qui vengono memorizzati i nomi utente degli utenti registrati.
   - **MAil:** Qui vengono memorizzate le mail degli utenti registrati.
   - **Password:** Questo campo conterrà le password degli utenti. È fondamentale assicurarsi che le password siano crittografate e sicure.
   - **Usertypeid:** Questo campo stabilisce una relazione tra la tabella "Users" e la tabella "UserTypes" tramite un identificatore. Lo useremo per determinare il tipo di utente (ad esempio, amministratore, utente normale) collegando il campo "Usertypeid" alla tabella "UserTypes".

**2. Tabella "UserTypes":**
   - **Usertypeid:** Questo campo rappresenta l'identificatore unico per ciascun tipo di utente. Ogni tipo di utente avrà un valore univoco in questa tabella.
   - **Type:** Qui definiremo il tipo di utente, ad esempio, "amministratore," "utente normale," ecc.
   - **Description:** Questo campo può contenere una breve descrizione del tipo di utente, offrendo ulteriori dettagli.

Le due tabelle sono collegate tra loro attraverso il campo "Usertypeid," consentendoci di associare ogni utente a un tipo specifico.

# Modello Fisico Utenti ( Create Table)

```sql
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Mail VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Usertypeid INT NOT NULL,
    FOREIGN KEY (Usertypeid) REFERENCES UserTypes(Usertypeid)
);
```

**Creazione della Tabella "UserTypes":**
```sql
CREATE TABLE UserTypes (
    Usertypeid INT AUTO_INCREMENT PRIMARY KEY,
    Type VARCHAR(50) NOT NULL,
    Description VARCHAR(255)
);
```

Ora, spieghiamo ciascuna di queste query:

**Creazione della Tabella "Users":**
- `CREATE TABLE Users`: Questa parte inizia la definizione della tabella "Users".
- `(UserID INT AUTO_INCREMENT PRIMARY KEY)`: Questa riga crea un campo chiamato "UserID" che è un intero (INT), che si auto-incrementa (AUTO_INCREMENT) e funge da chiave primaria (PRIMARY KEY). Questo campo sarà unico per ciascun utente e verrà generato automaticamente.
- `(Username VARCHAR(50) NOT NULL UNIQUE)`: Questa riga definisce il campo "Username" come una stringa di massimo 50 caratteri e richiede che sia obbligatorio (NOT NULL) e unico (UNIQUE). Ciò significa che ogni username nella tabella "Users" deve essere unico.
- `(Mail VARCHAR(100) NOT NULL UNIQUE)`: Questa riga crea il campo "Mail" come una stringa di massimo 100 caratteri e richiede che sia obbligatorio e unico. Ogni indirizzo email nella tabella "Users" deve essere unico.
- `(Password VARCHAR(255) NOT NULL)`: Questa riga crea il campo "Password" come una stringa di massimo 255 caratteri e richiede che sia obbligatorio.
- `(Usertypeid INT NOT NULL)`: Questa riga definisce il campo "Usertypeid" come un intero e richiede che sia obbligatorio.
- `FOREIGN KEY (Usertypeid) REFERENCES UserTypes(Usertypeid)`: Questa riga crea una relazione tra il campo "Usertypeid" nella tabella "Users" e il campo "Usertypeid" nella tabella "UserTypes". Questo permette di collegare ogni utente a un tipo specifico.

**Creazione della Tabella "UserTypes":**
- `CREATE TABLE UserTypes`: Questa parte inizia la definizione della tabella "UserTypes".
- `(Usertypeid INT AUTO_INCREMENT PRIMARY KEY)`: Questa riga crea un campo chiamato "Usertypeid" che è un intero, si auto-incrementa e funge da chiave primaria.
- `(Type VARCHAR(50) NOT NULL)`: Questa riga definisce il campo "Type" come una stringa di massimo 50 caratteri e richiede che sia obbligatorio.
- `(Description VARCHAR(255))`: Questa riga crea il campo "Description" come una stringa di massimo 255 caratteri, ma non richiede che sia obbligatorio.

Queste query SQL definiscono la struttura delle tabelle "Users" e "UserTypes" e stabiliscono una relazione tra di loro tramite il campo "Usertypeid." 


# Controllo Password

Per collegare il nostro database al PHP useremo delle stored procedure, cioè delle query salvate all'interno del nostro database. Le stored procedure offrono un approccio strutturato e sicuro, consentendo inoltre una migliore separazione tra la logica dell'applicazione e il database. Il seguente codice va inserito ed eseguito come una normale query sql

```sql
DELIMITER //
CREATE PROCEDURE GetPasswordByUsernameOrEmail(
    IN inputData VARCHAR(100)
)
BEGIN
    -- Cerca sia per username che per email e restituisci la password trovata
    SELECT Password FROM Users WHERE Username = inputData OR Mail = inputData;
END //
DELIMITER ;
```

- `DELIMITER //`: Inizia impostando un nuovo delimitatore temporaneo (`//`) per consentire la definizione della stored procedure senza conflitti con il delimitatore di istruzioni SQL predefinito (`;`).

- `CREATE PROCEDURE GetPasswordByUsernameOrEmail(IN inputData VARCHAR(100))`: Questa riga crea una nuova stored procedure chiamata `GetPasswordByUsernameOrEmail`. La stored procedure accetta un parametro di input `inputData`, che deve essere una stringa di testo con una lunghezza massima di 100 caratteri. Questo parametro sarà utilizzato per passare un valore (username o email) alla stored procedure in modo da cercare la password corrispondente.

- `BEGIN`: Segna l'inizio del corpo della stored procedure. Tutto ciò che segue tra `BEGIN` e `END` costituisce il corpo della procedura.

- `SELECT Password FROM Users WHERE Username = inputData OR Mail = inputData;`: Questa è la parte principale della stored procedure. Utilizza una query SQL `SELECT` per cercare la password nell'insieme di dati della tabella "Users." La query è strutturata come segue:
  - `SELECT Password`: Richiede la selezione della colonna "Password" dalla tabella "Users".
  - `FROM Users`: Specifica che la tabella da cui verrà selezionata la colonna è "Users."
  - `WHERE Username = inputData OR Mail = inputData`: Impone una condizione per la selezione, cercando corrispondenze nell'attributo "Username" o "Mail" della tabella "Users" in base al valore passato come parametro `inputData`.
  
- `END //`: Segna la fine del corpo della stored procedure.

- `DELIMITER ;`: Ripristina il delimitatore di istruzioni SQL predefinito (`;`) per le query successive.

In sintesi, questa stored procedure accetta un valore (username o email) come parametro di input, quindi cerca nella tabella "Users" una corrispondenza in base a questo valore. Se una corrispondenza viene trovata, la stored procedure restituirà la password associata. Questo è un metodo sicuro e riusabile per ottenere la password di un utente in base al suo username o email e rappresenta un esempio di utilizzo delle stored procedure per semplificare le interrogazioni del database nel tuo codice PHP, migliorando la sicurezza e la manutenibilità.
