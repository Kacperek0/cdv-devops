## Zadanie zaliczeniowe
Klient zwraca się do Ciebie z prośbą o usprawnienie swojej aplikacji wsparcia sprzedaży. Aplikacja ta ma za zadanie wspierać sprzedawców w ich codziennych obowiązkach. Aplikacja posiada frontend napisany przy uzyciu Reacta, backend napisany przy uzyciu Pythona z frameworkiem FastAPI oraz bazę danych PostgreSQL. Ruch sieciowy obsługiwany jest przez NGINX.

Zarówno frontend jaki i backend są bezstanowe, co oznacza, że nie przechowują żadnych danych. Wszystkie dane przechowywane są w bazie danych. Wszystkie komunikaty między komponentami aplikacji są w formacie JSON.

Klient obecnie korzysta z chmury Azure. Całe rozwiązanie zostało wrdozone przez firmę zewnętrzną, która nie jest w stanie dalej rozwija aplikacji.

Firma zewnętrzna zbudowała wszystkie komponenty na jednej wirtualnej maszynie. Obecnie aplikacja jest bardzo wolna, gdyz korzysta z niej cały dział sprzedazy. Klient chce, przygotował rozwiązanie, które pozwoli mu na dalsze rozwijanie aplikacji. Rozwiązanie powinno być w pełni skalowalne, a także łatwe w utrzymaniu. Jest otwarty na propozycje, jednak Twój wybór powinien byc uzasadniony.

Klient obecnie nie posiada zadnego monitoringu. Chce, abyś zaproponował rozwiązanie, które pozwoli mu na monitorowanie swojej aplikacji.

### Deployment aplikacji
*Jedna z bibliotek do obsługi Azure SDK wymaga Pythona przynajmniej w wersji 3.10*

1. Sklonuj repozytorium z kodem aplikacji
```bash
git clone https://github.com/Kacperek0/cdv-devops.git
```
2. Przy pomocy Azure CLI utwórz service principal, który będzie wykorzystywany do deploymentu aplikacji
```bash
az ad sp create-for-rbac --name "cdv-devops" --role contributor --scopes /subscriptions/<SUBSCRIPTION_ID>
```
3. Skopiuj plik .env.example do .env i wypełnij zmienne środowiskowe. Wartości zmiennych będą wynikiem wykonania komendy z punktu 2.
```bash
cp .env.example .env
```
4. Zainstaluj zależności
```bash
pip install -r requirements.txt
```
5. Zbuduj infrastrukturę
```bash
python build.py
```
6. Po zbudowaniu infrastruktury znajdź publiczny adres IP i połącz się z maszyną przez SSH. Domyślnie użytkownik to `azureuser`. Domyslne hasło to `Password123!`.
```bash
ssh azureuser@<PUBLIC_IP>
```
7. Sklonuj repozytorium na maszynę
```bash
git clone https://github.com/Kacperek0/cdv-devops.git
```
8. Przejdź do katalogu `cdv-devops/Zaliczenie/Infra`
```bash
cd cdv-devops/Zaliczenie/Infra
```
9. Nadaj uprawnienia do wykonania skryptu
```bash
chmod +x setup.sh
```
10. Uruchom skrypt
```bash
./setup.sh
```
11. Po zakończeniu skryptu aplikacja powinna być dostępna pod adresem `http://<PUBLIC_IP>`
12. Aby usunąć infrastrukturę, usuń resource group `sales-prod-rg` z Azure Portal lub wykonaj komendę
```bash
az group delete --name sales-prod-rg
```
