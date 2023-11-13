# Database

E' giunto il momento di introdurre un elemento fondamentale per molte applicazioni web: il database. I database sono componenti essenziali in cui vengono archiviati dati come utenti, prodotti e informazioni cruciali per il funzionamento dell'applicazione.

In questa sezione, esploreremo l'importanza di un database per la nostra applicazione e inizieremo gradualmente a costruire il nostro. Cominceremo dalla gestione degli utenti, un elemento centrale per la maggior parte delle applicazioni web. Creeremo tabelle, definiremo la struttura dei dati e impareremo a inserire, recuperare e gestire informazioni sugli utenti.

# Modello Logico Utenti

Nel nostro modello logico, ci concentreremo su due tabelle principali:

**1. Tabella "Users":**
   - **UserID:** Questo campo rappresenta un identificatore unico per ciascun utente. Sarà utilizzato per distinguere gli utenti in modo univoco.
   - **Username:** Qui vengono memorizzati i nomi utente degli utenti registrati.
   - **Mail:** Qui vengono memorizzate le mail degli utenti registrati.
   - **Password:** Questo campo conterrà le password degli utenti. È fondamentale assicurarsi che le password siano crittografate e sicure.
   - **Usertypeid:** Questo campo stabilisce una relazione tra la tabella "Users" e la tabella "UserTypes" tramite un identificatore. Lo useremo per determinare il tipo di utente (ad esempio, amministratore, utente normale) collegando il campo "Usertypeid" alla tabella "UserTypes".

**2. Tabella "UserTypes":**
   - **Usertypeid:** Questo campo rappresenta l'identificatore unico per ciascun tipo di utente. Ogni tipo di utente avrà un valore univoco in questa tabella.
   - **Type:** Qui definiremo il tipo di utente, ad esempio, "amministratore," "utente normale," ecc.
   - **Description:** Questo campo può contenere una breve descrizione del tipo di utente, offrendo ulteriori dettagli.

Le due tabelle sono collegate tra loro attraverso il campo "Usertypeid," consentendoci di associare ogni utente a un tipo specifico.

# Attive e Gestire il DB

Per attivare il server MySQL con XAMPP, segui questi passaggi:

1. Apri il pannello di controllo di XAMPP.
2. Clicca sul pulsante **Start** accanto al servizio **MySQL**.

### Accedere a phpMyAdmin

Per accedere a phpMyAdmin pri un browser web e inserisci l'indirizzo **http://localhost/phpmyadmin**.

Verrai reindirizzato alla pagina principale di phpMyAdmin.

### Creare un database

Per creare un database, segui questi passaggi:

1. Fai clic sulla scheda **Database**.
2. Nella casella **Nome database**, digita il nome del database che desideri creare, in questa guida utilizzerò **ecommercedb**
3. Fai clic sul pulsante **Crea**.

# Dove scrivere le query

1. Accedi a phpMyAdmin.

Per accedere a phpMyAdmin, apri un browser web e inserisci l'indirizzo **http://localhost/phpmyadmin**.

2. Seleziona il database su cui desideri eseguire la query.

Nella barra laterale sinistra, seleziona il database su cui desideri eseguire la query.

3. Fai clic sulla scheda **SQL**.

Nella parte superiore della pagina, fai clic sulla scheda **SQL**.

4. Digita la query che desideri eseguire nella casella **Esegui query**.

Nella casella **Esegui query**, digita la query che desideri eseguire.

5. Fai clic sul pulsante **Esegui**.

Fai clic sul pulsante **Esegui** in basso a destra per eseguire la query.

# Modello Fisico Utenti ( Create Table)

Seguendo la guida precedente, scriviamo le query per creare le nostre tabelle

```sql
CREATE TABLE UserTypes (
    Usertypeid INT AUTO_INCREMENT PRIMARY KEY,
    Type VARCHAR(50) NOT NULL,
    Description VARCHAR(255)
);

CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Mail VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Usertypeid INT NOT NULL,
    FOREIGN KEY (Usertypeid) REFERENCES UserTypes(Usertypeid)
);
```

Ora, spieghiamo ciascuna di queste query:

**Creazione della Tabella "UserTypes":**
- `CREATE TABLE UserTypes`: Questa parte inizia la definizione della tabella "UserTypes".
- `(Usertypeid INT AUTO_INCREMENT PRIMARY KEY)`: Questa riga crea un campo chiamato "Usertypeid" che è un intero, si auto-incrementa e funge da chiave primaria.
- `(Type VARCHAR(50) NOT NULL)`: Questa riga definisce il campo "Type" come una stringa di massimo 50 caratteri e richiede che sia obbligatorio.
- `(Description VARCHAR(255))`: Questa riga crea il campo "Description" come una stringa di massimo 255 caratteri, ma non richiede che sia obbligatorio.

**Creazione della Tabella "Users":**
- `CREATE TABLE Users`: Questa parte inizia la definizione della tabella "Users".
- `(UserID INT AUTO_INCREMENT PRIMARY KEY)`: Questa riga crea un campo chiamato "UserID" che è un intero (INT), che si auto-incrementa (AUTO_INCREMENT) e funge da chiave primaria (PRIMARY KEY). Questo campo sarà unico per ciascun utente e verrà generato automaticamente.
- `(Username VARCHAR(50) NOT NULL UNIQUE)`: Questa riga definisce il campo "Username" come una stringa di massimo 50 caratteri e richiede che sia obbligatorio (NOT NULL) e unico (UNIQUE). Ciò significa che ogni username nella tabella "Users" deve essere unico.
- `(Mail VARCHAR(100) NOT NULL UNIQUE)`: Questa riga crea il campo "Mail" come una stringa di massimo 100 caratteri e richiede che sia obbligatorio e unico. Ogni indirizzo email nella tabella "Users" deve essere unico.
- `(Password VARCHAR(255) NOT NULL)`: Questa riga crea il campo "Password" come una stringa di massimo 255 caratteri e richiede che sia obbligatorio.
- `(Usertypeid INT NOT NULL)`: Questa riga definisce il campo "Usertypeid" come un intero e richiede che sia obbligatorio.
- `FOREIGN KEY (Usertypeid) REFERENCES UserTypes(Usertypeid)`: Questa riga crea una relazione tra il campo "Usertypeid" nella tabella "Users" e il campo "Usertypeid" nella tabella "UserTypes". Questo permette di collegare ogni utente a un tipo specifico.

Queste query SQL definiscono la struttura delle tabelle "Users" e "UserTypes" e stabiliscono una relazione tra di loro tramite il campo "Usertypeid." 


# Controllo Password

Per collegare il nostro database al PHP useremo delle stored procedure, cioè delle query salvate all'interno del nostro database. Le stored procedure offrono un approccio strutturato e sicuro, consentendo inoltre una migliore separazione tra la logica dell'applicazione e il database. Il seguente codice va inserito ed eseguito come una normale query sql

```sql
DELIMITER //
CREATE PROCEDURE GetPasswordByUsername(
    IN inputData VARCHAR(100)
)
BEGIN
    -- Cerca l'username nella tabella Users e restituisci la password trovata
    SELECT Password FROM Users WHERE Username = inputData;
END //
DELIMITER ;
```

**Spiegazione Dettagliata:**

1. **DELIMITER //:** Questo imposta un delimitatore diverso (`//`) per consentire la definizione di stored procedure con istruzioni SQL più complesse.

2. **CREATE PROCEDURE GetPasswordByUsername(...):** Questa riga inizia la definizione della stored procedure denominata `GetPasswordByUsername`. La stored procedure accetta un parametro di input `inputData` di tipo VARCHAR(100), che rappresenta l'username.

3. **BEGIN:** Segna l'inizio del corpo della stored procedure.

4. **SELECT Password FROM Users WHERE Username = inputData;:** Questa istruzione SQL effettua una query sulla tabella `Users`. Cerca una riga in cui il campo `Username` corrisponde all'`inputData` fornito. Se trova una corrispondenza, restituisce la password associata a quell'username.

5. **END //:** Segna la fine del corpo della stored procedure.

6. **DELIMITER ;:** Ripristina il delimitatore predefinito (`;`) alla fine della definizione della stored procedure.

**Importanza dell'Uso delle Stored Procedure:**

- **Sicurezza:** Le stored procedure possono contribuire a prevenire attacchi di SQL injection, poiché i parametri vengono trattati in modo sicuro.

- **Riusabilità del Codice:** Le stored procedure possono essere richiamate da più parti dell'applicazione, promuovendo la riusabilità del codice.

- **Ottimizzazione delle Prestazioni:** Le stored procedure possono essere ottimizzate e memorizzate nella cache del database per migliorare le prestazioni delle query frequenti.

Utilizzando stored procedure, si favorisce una gestione più sicura, efficiente e organizzata delle operazioni nel database.
