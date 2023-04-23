#!/bin/bash
modprobe -n -v hfsplus | grep -E '(hfsplus|install)'
lsmod | grep hfsplus
