git add .
git commit -m "update $(date +%Y-%m-%d-%H-%M-%S)"
git push origin $(git branch | grep \* | cut -d ' ' -f2)
