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
