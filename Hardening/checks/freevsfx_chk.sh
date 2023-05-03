#!/bin/bash
modprobe -n -v freevxfs | grep -E '(freevxfs|install)'
lsmod | grep freevxfs
