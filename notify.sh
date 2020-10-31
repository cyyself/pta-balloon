#!/bin/bash
#
# Usage:
#   php check.php | ./notify.sh
#

while read line;do
	if grep -E "^T[[:digit:]]+" <(echo "$line") &>/dev/null;then
		echo "$line"
		notify-send "$line"
		play -q Mallet.ogg &>/dev/null
	fi
done

