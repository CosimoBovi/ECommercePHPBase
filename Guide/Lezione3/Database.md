# Database

E' giunto il momento di introdurre un elemento fondamentale per molte applicazioni web: il database. I database sono componenti essenziali in cui vengono archiviati dati come utenti, prodotti e informazioni cruciali per il funzionamento dell'applicazione.

In questa sezione, esploreremo l'importanza di un database per la nostra applicazione e inizieremo gradualmente a costruire il nostro. Cominceremo dalla gestione degli utenti, un elemento centrale per la maggior parte delle applicazioni web. Creeremo tabelle, definiremo la struttura dei dati e impareremo a inserire, recuperare e gestire informazioni sugli utenti.

# Modello Logico Utenti

Nel nostro modello logico, ci concentreremo su due tabelle principali:

**1. Tabella "Users":**
   - **UserID:** Questo campo rappresenta un identificatore unico per ciascun utente. Sarà utilizzato per distinguere gli utenti in modo univoco.
   - **Username:** Qui vengono memorizzati i nomi utente degli utenti registrati.
   - **Password:** Questo campo conterrà le password degli utenti. È fondamentale assicurarsi che le password siano crittografate e sicure.
   - **Usertypeid:** Questo campo stabilisce una relazione tra la tabella "Users" e la tabella "UserTypes" tramite un identificatore. Lo useremo per determinare il tipo di utente (ad esempio, amministratore, utente normale) collegando il campo "Usertypeid" alla tabella "UserTypes".

**2. Tabella "UserTypes":**
   - **Usertypeid:** Questo campo rappresenta l'identificatore unico per ciascun tipo di utente. Ogni tipo di utente avrà un valore univoco in questa tabella.
   - **Type:** Qui definiremo il tipo di utente, ad esempio, "amministratore," "utente normale," ecc.
   - **Description:** Questo campo può contenere una breve descrizione del tipo di utente, offrendo ulteriori dettagli.

Le due tabelle sono collegate tra loro attraverso il campo "Usertypeid," consentendoci di associare ogni utente a un tipo specifico.

