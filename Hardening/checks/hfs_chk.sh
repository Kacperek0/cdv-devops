#!/bin/bash
modprobe -n -v hfs | grep -E '(hfs|install)'
lsmod | grep hfs
