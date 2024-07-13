import styles from "./searchPanel.module.css";

function SearchPanel() {
  return (
    <>
      <input className={styles.input} placeholder="Введите название" />
    </>
  );
}

export default SearchPanel;
