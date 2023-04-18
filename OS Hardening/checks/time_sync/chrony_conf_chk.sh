#!/usr/bin/env bash
grep -Pr --include=*.{sources,conf} '^\h*(server|pool)\h+\H+' /etc/chrony/
ps -ef | awk '(/[c]hronyd/ && $1!="_chrony") { print $1 }'
