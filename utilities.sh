#!/bin/bash

# Major Release => `./utilities.sh bump major`
# Minor Release => `./utilities.sh bump minor`
# Patch Release => `./utilities.sh bump patch`

YELLOW='\033[0;33m'
GREEN='\033[0;32m'
RED='\033[0;31m'
END='\033[0m'

function generateVersion {
	output=$(npm version ${release} --no-git-tag-version)
	version=${output:1}

	echo -e "${GREEN}Bumping theme version to v${version}.${END}"
}

function bump {
	# *.json files
	search='("version":[[:space:]]*").+(")'
	replace="\1${version}\2"
	sed -i ".tmp" -E "s/${search}/${replace}/g" "$1"

	# .css theme file
	search='(Version:[[:space:]]).+'
	replace="\1${version}"
	sed -i ".tmp" -E "s/${search}/${replace}/g" "$1"

	rm "$1.tmp"
}

function help {
	echo -e "${GREEN}Usage: $(basename $0) bump [<newversion> | major | minor | patch | premajor | preminor | prepatch | prerelease]${END}"
}

if [ -z "$1" ] || [ "$1" = "help" ]; then

	help
	exit

elif [ "$1" = "bump" ]; then

	release=$2

	if [ -d ".git" ]; then
		branch=$(git branch --show-current)
		changes=$(git status --porcelain)

		# only run on master
		if [ "${branch}" != "master" ]; then
			echo -e "${RED}Please switch to master branch before running this command.${END}"
			exit
		fi

		# stash any active changes
		if [ "${changes}" ]; then
			echo -e "${YELLOW}Stashing changes as 'pre-release changes'.${END}"

			git stash save "pre-release changes" --include-untracked
		fi

		generateVersion

		bump "composer.json"
		bump "package.json"
		bump "package-lock.json"
		bump "style.css"

		git add .
		git commit -m "Bump theme version to v${version}."
		git tag -a "${output}" -m "v${version}"
		git push --atomic origin master "${output}"
		if command -v gh &> /dev/null; then
			gh release create v${version} -t v${version}
		fi
	else
		generateVersion

		bump "composer.json"
		bump "package.json"
		bump "package-lock.json"
		bump "style.css"
	fi
fi
