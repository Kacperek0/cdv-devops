git add .
git commit -m "update"
git push origin $(git branch | grep \* | cut -d ' ' -f2)
