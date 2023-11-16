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

# Attivare e Gestire il DB

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



# Come consegnare il database

**E' importante ricordarsi di salvare il database dopo averlo creato o modificato**

Per salvare il database seguire questi passaggi:

1. **Accedi a phpMyAdmin:**
   - Apri il tuo browser e vai all'indirizzo in cui è installato phpMyAdmin (http://localhost/phpmyadmin/).

2. **Seleziona il Database:**
   - Nella barra laterale sinistra, trova e seleziona il database che desideri esportare.

3. **Scegli l'Opzione "Esporta":**
   - Nella parte superiore della pagina, vai alla scheda "Esporta" (Export).

4. **Configura le Opzioni di Esportazione:**
   - Lascia selezionato il formato "SQL".

5. **Scorri verso il Basso e Clicca su "Vai" o "Esegui":**
   - Scendi verso il basso della pagina e trova il pulsante "Vai" o "Esegui" per avviare il processo di esportazione.

6. **Salva il File .sql:**
   - Verrà generato un file .sql contenente il dump del tuo database.
   - Una finestra di dialogo ti chiederà di scaricare il file. 
   - Salva il file .sql nella posizione desiderata sul tuo computer.

Ora hai esportato con successo il tuo database in formato .sql utilizzando phpMyAdmin. Questo file può essere utilizzato per importare il database in un'altra installazione di MySQL o per il backup dei dati.

# Come riprendere il database

Per riprendere il database salvato in precedenza dobbiamo importare il file .sql creato

1. **Accedi a phpMyAdmin:**
   - Apri il tuo browser e vai all'indirizzo in cui è installato phpMyAdmin (solitamente http://localhost/phpmyadmin/).

2. **Crea un Nuovo Database :**
    Vai alla scheda "Database" e crea un nuovo database seguendo [Questa guida](#Creare-un-database).

3. **Seleziona il Database di Destinazione:**
   - Nella barra laterale sinistra, trova e seleziona il database appena creato.

4. **Vai alla Scheda "Importa" (Import):**
   - Sulla barra di navigazione superiore, vai alla scheda "Importa" (Import).

5. **Carica il File .sql:**
   - Sulla pagina di importazione, fai clic sul pulsante "Scegli file" o "Sfoglia" per selezionare il file .sql che hai esportato in precedenza.

6. **Fai clic su "Vai" o "Esegui":**
   - Scorri verso il basso e trova il pulsante "Vai" o "Esegui" per avviare il processo di importazione.

Ora hai importato con successo il database .sql in phpMyAdmin. Puoi verificare la presenza dei dati all'interno del database di destinazione.
