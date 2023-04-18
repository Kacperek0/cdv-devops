#!/usr/bin/env bash
ps -ef | awk '(/[c]hronyd/ && $1!="_chrony") { print $1 }'
